<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Procedure;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Formuler;
use App\Models\Repence;
use Illuminate\Support\Facades\Mail;
use App\Mail\DossierCreated;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Mail\FormCompleted;
use App\Mail\DossierCompleted;

class DossierController extends Controller
{
    public function index()
    {
        $agency = Auth::guard('agency')->user();
        $dossiers = Dossier::where('agency_id', $agency->id)
            ->with(['procedure', 'user', 'task'])
            ->latest()
            ->paginate(10);

        return view('agency.dossiers.index', compact('dossiers'));
    }

    public function create()
    {
        $procedures = Procedure::all();
        $users = User::all();
        $tasks = Task::all();
        return view('agency.dossiers.create', compact('procedures', 'users', 'tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'user_id' => 'required|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'status' => 'required|in:en_cours,en_attente,termine,rejete'
        ]);

        $dossier = new Dossier($request->all());
        $dossier->agency_id = Auth::guard('agency')->id();
        $dossier->save();

        // Get the first form from the procedure's task
        $procedure = Procedure::with(['tasks.formulers'])->find($request->procedure_id);
        $firstTask = $procedure->tasks->first();

        if ($firstTask && $firstTask->formulers->isNotEmpty()) {
            $firstForm = $firstTask->formulers->first();

            // Create a response for the first form
            Repence::create([
                'dossier_id' => $dossier->id,
                'formuler_id' => $firstForm->id,
                'status' => 'en_cours'
            ]);

            // Update dossier with current task
            $dossier->update(['task_id' => $firstTask->id]);
        }

        // Send email to admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Mail::to($admin->email)->send(new DossierCreated($dossier));
        }

        return redirect()->route('agency.dossiers.show', $dossier)
            ->with('success', 'Dossier créé avec succès. Le premier formulaire est prêt à être rempli.');
    }

    public function show(Dossier $dossier)
    {
        // Check if dossier belongs to this agency
        if ($dossier->agency_id !== Auth::guard('agency')->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Get current task and its form with eager loading
        $currentTask = $dossier->task()->with('formulers')->first();
        $currentForm = null;
        $currentResponse = null;
        $canFillForm = false;

        if ($currentTask && $currentTask->formulers->isNotEmpty()) {
            $currentForm = $currentTask->formulers->first();
            $currentResponse = Repence::where('dossier_id', $dossier->id)
                ->where('formuler_id', $currentForm->id)
                ->first();

            // Allow filling form only if response status is 'agency'
            $canFillForm = $currentResponse && $currentResponse->status === 'agency';
        }

        return view('agency.dossiers.show', compact('dossier', 'currentTask', 'currentForm', 'currentResponse', 'canFillForm'));
    }

    public function edit(Dossier $dossier)
    {
        return view('agency.dossiers.edit', compact('dossier'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $validated = $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'user_id' => 'required|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'status' => 'required|in:en_cours,en_attente,termine,rejete'
        ]);

        $dossier->update($validated);

        return redirect()->route('agency.dossiers.index')
            ->with('success', 'Dossier mis à jour avec succès.');
    }

    public function destroy(Dossier $dossier)
    {
        $dossier->delete();

        return redirect()->route('agency.dossiers.index')
            ->with('success', 'Dossier supprimé avec succès.');
    }

    public function showResponse(Dossier $dossier, Repence $response)
    {
        // Check if dossier belongs to this agency
        if ($dossier->agency_id !== Auth::guard('agency')->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Check if response belongs to this dossier
        if ($response->dossier_id !== $dossier->id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('agency.dossiers.responses.show', compact('dossier', 'response'));
    }

    public function createResponse(Dossier $dossier, Request $request)
    {
        // Check if dossier belongs to this agency
        if ($dossier->agency_id !== Auth::guard('agency')->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Get the form to fill
        $form = Formuler::findOrFail($request->form);

        // Check if form belongs to current task
        if ($form->task_id !== $dossier->task_id) {
            abort(403, 'Ce formulaire n\'est pas disponible pour ce dossier.');
        }

        // Check if response already exists
        $existingResponse = Repence::where('dossier_id', $dossier->id)
            ->where('formuler_id', $form->id)
            ->first();

        if ($existingResponse) {
            return redirect()->route('agency.dossiers.responses.edit', ['dossier' => $dossier->id, 'response' => $existingResponse->id])
                ->with('info', 'Ce formulaire a déjà été commencé.');
        }

        return view('agency.dossiers.responses.create', compact('dossier', 'form'));
    }

    public function storeResponse(Request $request, Dossier $dossier)
    {
        try {
            // Check if dossier belongs to this agency
            if ($dossier->agency_id !== Auth::guard('agency')->id()) {
                abort(403, 'Accès non autorisé.');
            }

            // Get the form with its relationships
            $form = Formuler::with(['task.etap', 'task.procedure'])->findOrFail($request->formuler_id);

            // Load dossier relationships for email
            $dossier->load(['agency', 'user', 'procedure']);

            $questions = $form->variables;
            $answers = $request->answers;

            foreach ($form->variables as $question) {
                if($question->type == 'file'){
                    $file = $request->answers[$question->id];
                    $path = $file->store('', 'public');
                    $answers[$question->id] = 'uploads/'.$path;
                }
            }

            // Create the response
            $response = Repence::create([
                'dossier_id' => $dossier->id,
                'formuler_id' => $form->id,
                'status' => 'termine',
                'answers' => $answers
            ]);

            // Move to next task if available
            $currentTask = $form->task;
            $etape = $currentTask->etap;

            $nextTask = Task::where('etap_id', $etape->procedure_id)
                ->where('order', '>', $currentTask->order)
                ->orderBy('order')
                ->first();

            if ($nextTask) {
                $dossier->update(['task_id' => $nextTask->id]);

                // Create response for next form if exists
                $nextForm = $nextTask->formulers->first();
                if ($nextForm) {
                    Repence::create([
                        'dossier_id' => $dossier->id,
                        'formuler_id' => $nextForm->id,
                        'status' => 'en_cours'
                    ]);
                }

                // Send email notifications for form completion
                $this->sendFormCompletionEmails($dossier, $form, $nextTask);
            } else {
                $dossier->update(['status' => 'termine']);
                // Send email notifications for dossier completion
                $this->sendDossierCompletionEmails($dossier, $form);
            }

            return redirect()->route('agency.dossiers.show', $dossier)
                ->with('success', 'Formulaire complété avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la soumission du formulaire: ' . $e->getMessage());
        }
    }

    /**
     * Send email notifications when a form is completed
     */
    private function sendFormCompletionEmails($dossier, $form, $nextTask)
    {
        try {
            // Get admin user
            $admin = Admin::first();

            $emailData = [
                'dossier' => $dossier,
                'form' => $form,
                'nextTask' => $nextTask,
                'agency' => $dossier->agency,
                'user' => $dossier->user
            ];

            if ($admin) {
                // Send email to admin using container
                Mail::to($admin->email)->send(app()->make(FormCompleted::class, [
                    'data' => $emailData
                ]));
            }

            // Send email to dossier user using container
            if ($dossier->user && $dossier->user->email) {
                Mail::to($dossier->user->email)->send(app()->make(FormCompleted::class, [
                    'data' => $emailData
                ]));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending form completion emails: ' . $e->getMessage());
        }
    }

    /**
     * Send email notifications when a dossier is completed
     */
    private function sendDossierCompletionEmails($dossier, $form)
    {
        try {
            // Get admin user
            $admin = Admin::first();

            $emailData = [
                'dossier' => $dossier,
                'form' => $form,
                'agency' => $dossier->agency,
                'user' => $dossier->user
            ];

            if ($admin) {
                // Send email to admin using container
                Mail::to($admin->email)->send(app()->make(DossierCompleted::class, [
                    'data' => $emailData
                ]));
            }

            // Send email to dossier user using container
            if ($dossier->user && $dossier->user->email) {
                Mail::to($dossier->user->email)->send(app()->make(DossierCompleted::class, [
                    'data' => $emailData
                ]));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending dossier completion emails: ' . $e->getMessage());
        }
    }

    public function editResponse(Dossier $dossier, Repence $response)
    {
        // Check if dossier belongs to this agency
        if ($dossier->agency_id !== Auth::guard('agency')->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Check if response belongs to this dossier
        if ($response->dossier_id !== $dossier->id) {
            abort(403, 'Accès non autorisé.');
        }

        // Check if response status is 'agency'
        if ($response->status !== 'agency') {
            abort(403, 'Ce formulaire n\'est pas disponible pour modification.');
        }

        // Load the form with its questions
        $response->load('formuler.questions');

        return view('agency.dossiers.responses.edit', compact('dossier', 'response'));
    }

    public function updateResponse(Request $request, Dossier $dossier, Repence $response)
    {
        // Check if dossier belongs to this agency
        if ($dossier->agency_id !== Auth::guard('agency')->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Check if response belongs to this dossier
        if ($response->dossier_id !== $dossier->id) {
            abort(403, 'Accès non autorisé.');
        }

        // Check if response status is 'agency'
        if ($response->status !== 'agency') {
            abort(403, 'Ce formulaire n\'est pas disponible pour modification.');
        }

        // Load the form to validate against its questions
        $response->load('formuler.questions');

        // Build validation rules based on form questions
        $rules = [];
        foreach ($response->formuler->questions as $question) {
            $rules["answers.{$question->id}"] = 'required|string';
        }

        $request->validate($rules);

        // Update the response
        $response->update([
            'answers' => $request->answers,
            'status' => 'termine' // Mark as completed after agency fills it
        ]);

        // Move to next task if available
        $currentTask = $dossier->task;
        $nextTask = Task::where('procedure_id', $dossier->procedure_id)
            ->where('order', '>', $currentTask->order)
            ->orderBy('order')
            ->first();

        if ($nextTask) {
            $dossier->update(['task_id' => $nextTask->id]);

            // Create response for next form if exists
            $nextForm = $nextTask->formulers->first();
            if ($nextForm) {
                Repence::create([
                    'dossier_id' => $dossier->id,
                    'formuler_id' => $nextForm->id,
                    'status' => 'en_cours'
                ]);
            }
        }

        return redirect()->route('agency.dossiers.show', $dossier)
            ->with('success', 'Formulaire complété avec succès.');
    }
}
