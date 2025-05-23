<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Procedure;
use App\Models\Agency;
use App\Models\User;
use App\Models\Task;
use App\Models\Formuler;
use App\Models\Repence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DossierCreated;
use Illuminate\Support\Facades\DB;
class DossierController extends Controller
{
    public function index()
    {
        $dossiers = Dossier::with(['procedure', 'agency', 'user', 'task'])->latest()->paginate(10);
        return view('admin.dossiers.index', compact('dossiers'));
    }

    public function create()
    {
        $procedures = Procedure::all();
        $agencies = Agency::all();
        $users = User::all();
        $tasks = Task::all();
        return view('admin.dossiers.create', compact('procedures', 'agencies', 'users', 'tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'agency_id' => 'required|exists:agencies,id',
            'user_id' => 'required|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'status' => 'required|in:en_cours,en_attente,termine,rejete'
        ]);

        $dossier = Dossier::create($request->all());

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

        return redirect()->route('admin.dossiers.show', $dossier)
            ->with('success', 'Dossier créé avec succès. Le premier formulaire est prêt à être rempli.');
    }

    public function show(Dossier $dossier)
    {
        // Load the dossier with necessary relationships
        $dossier->load([
            'procedure',
            'agency',
            'user',
            'task',
            'task.formulers',
            'repences.formuler.task',
            'repences.formuler.variables'
        ]);

        // Check if current task is for admin
        $isAdminTask = $dossier->task && $dossier->task->intervenant === 'admin';

        // Get available forms for the current task
        $availableForms = collect();
        if ($isAdminTask) {
            $availableForms = $dossier->task->formulers->filter(function($form) use ($dossier) {
                return !$dossier->repences->where('formuler_id', $form->id)->count();
            });
        }

        // Get admin responses
        $adminResponses = $dossier->repences->filter(function($response) {
            return $response->formuler->task->intervenant === 'admin';
        });

        // Get statistics for this dossier
        $stats = [
            'total_forms' => $isAdminTask ? $dossier->task->formulers->count() : 0,
            'completed_forms' => $adminResponses->where('status', 'termine')->count(),
            'pending_forms' => $adminResponses->where('status', 'admin')->count(),
            'next_task' => null
        ];

        // Get next task if current task is admin task
        if ($isAdminTask && $dossier->task->etap) {
            $stats['next_task'] = Task::where('etap_id', $dossier->task->etap_id)
                ->where('order', '>', $dossier->task->order)
                ->orderBy('order')
                ->first();
        }

        return view('admin.dossiers.show', compact('dossier', 'stats', 'availableForms', 'adminResponses', 'isAdminTask'));
    }

    public function edit(Dossier $dossier)
    {
        $procedures = Procedure::all();
        $agencies = Agency::all();
        $users = User::all();
        $tasks = Task::all();
        return view('admin.dossiers.edit', compact('dossier', 'procedures', 'agencies', 'users', 'tasks'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'agency_id' => 'required|exists:agencies,id',
            'user_id' => 'required|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'status' => 'required|in:en_cours,en_attente,termine,rejete'
        ]);

        $dossier->update($request->all());

        return redirect()->route('admin.dossiers.index')
            ->with('success', 'Dossier mis à jour avec succès.');
    }

    public function destroy(Dossier $dossier)
    {
        $dossier->delete();

        return redirect()->route('admin.dossiers.index')
            ->with('success', 'Dossier supprimé avec succès.');
    }

    public function createResponse(Dossier $dossier)
    {
        // Get the current task's form
        $form = Formuler::where('task_id', $dossier->task_id)
            ->with(['variables'])
            ->firstOrFail();

        // Check if form exists and belongs to a task with admin intervenant
        if (!$form || $form->task->intervenant !== 'admin') {
            abort(403, 'Ce formulaire n\'est pas disponible pour l\'administrateur.');
        }

        return view('admin.dossiers.responses.create', compact('dossier', 'form'));
    }

    public function storeResponse(Request $request, Dossier $dossier)
    {
        try {
            DB::beginTransaction();

            // Get the form
            $form = Formuler::findOrFail($request->formuler_id);

            // Check if form belongs to current task and is for admin
            if ($form->task_id !== $dossier->task_id || $form->task->intervenant !== 'admin') {
                abort(403, 'Ce formulaire n\'est pas disponible pour l\'administrateur.');
            }

            // Load the form variables
            $form->load('variables');

            // Validate answers based on variables
            $validationRules = [];
            foreach ($form->variables as $variable) {
                $validationRules['answers.' . $variable->id] = 'required';
                if ($variable->type === 'file') {
                    $validationRules['answers.' . $variable->id] = 'required|file|max:10240'; // 10MB max
                }
            }

            $request->validate($validationRules);

            // Process file uploads if any
            $answers = $request->answers;
            foreach ($form->variables as $variable) {
                if ($variable->type === 'file' && isset($request->file('answers')[$variable->id])) {
                    $file = $request->file('answers')[$variable->id];
                    $path = $file->store('uploads', 'public');
                    $answers[$variable->id] = $path;
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
                    $this->sendFormCompletionEmails($dossier, $nextForm, $nextTask);
                }
            } else {
                $dossier->update(['status' => 'termine']);
                $this->sendDossierCompletionEmails($dossier, $form);
            }

            DB::commit();

            return redirect()
                ->route('admin.dossiers.show', $dossier)
                ->with('success', 'Réponses soumises avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la soumission des réponses: ' . $e->getMessage());
        }
    }


    private function sendFormCompletionEmails($dossier, $form, $nextTask)
    {
        try {
            // Get admin user
            $agency = Agency::find($dossier->agency_id);

            if ($agency) {
                // Send email to admin
                Mail::to($agency->email)->send(new \App\Mail\FormCompleted([
                    'dossier' => $dossier,
                    'form' => $form,
                    'nextTask' => $nextTask,
                    'agency' => $dossier->agency,
                    'user' => $dossier->user
                ]));
            }

            // Send email to dossier user
            if ($dossier->user && $dossier->user->email) {
                Mail::to($dossier->user->email)->send(new \App\Mail\FormCompleted([
                    'dossier' => $dossier,
                    'form' => $form,
                    'nextTask' => $nextTask,
                    'agency' => $dossier->agency,
                    'user' => $dossier->user
                ]));
            }
        } catch (\Exception $e) {
            \Log::error('Error sending form completion emails: ' . $e->getMessage());
        }
    }

    /**
     * Send email notifications when a dossier is completed
     */
    private function sendDossierCompletionEmails($dossier, $form)
    {
        try {
            // Get admin user
            $agency = Agency::find($dossier->agency_id);

            if ($agency){
                // Send email to admin
                Mail::to($agency->email)->send(new \App\Mail\DossierCompleted([
                    'dossier' => $dossier,
                    'form' => $form,
                    'agency' => $dossier->agency,
                    'user' => $dossier->user
                ]));
            }

            // Send email to dossier user
            if ($dossier->user && $dossier->user->email) {
                Mail::to($dossier->user->email)->send(new \App\Mail\DossierCompleted([
                    'dossier' => $dossier,
                    'form' => $form,
                    'agency' => $dossier->agency,
                    'user' => $dossier->user
                ]));
            }
        } catch (\Exception $e) {
            \Log::error('Error sending dossier completion emails: ' . $e->getMessage());
        }
    }
    public function showResponse(Dossier $dossier, Repence $response)
    {
        // Ensure the response belongs to the dossier
        if ($response->dossier_id !== $dossier->id) {
            abort(404);
        }

        // Load the form with its variables
        $response->load(['formuler.variables']);

        return view('admin.dossiers.responses.show', compact('dossier', 'response'));
    }

    public function editResponse(Dossier $dossier, Repence $response)
    {
        // Ensure the response belongs to the dossier and is in admin status
        if ($response->dossier_id !== $dossier->id || $response->status !== 'admin') {
            abort(404);
        }

        // Load the form with its variables
        $form = $response->formuler;
        $form->load('variables');

        return view('admin.dossiers.responses.edit', compact('dossier', 'response', 'form'));
    }

    public function updateResponse(Request $request, Dossier $dossier, Repence $response)
    {
        // Ensure the response belongs to the dossier and is in admin status
        if ($response->dossier_id !== $dossier->id || $response->status !== 'admin') {
            abort(404);
        }

        try {
            DB::beginTransaction();

            // Load the form with its variables
            $form = $response->formuler;
            $form->load('variables');

            // Validate answers based on variables
            $validationRules = [];
            foreach ($form->variables as $variable) {
                $validationRules['answers.' . $variable->id] = 'required';
                if ($variable->type === 'file') {
                    $validationRules['answers.' . $variable->id] = 'nullable|file|max:10240'; // 10MB max
                }
            }

            $request->validate($validationRules);

            // Process file uploads if any
            $answers = $request->answers;
            foreach ($form->variables as $variable) {
                if ($variable->type === 'file' && isset($request->file('answers')[$variable->id])) {
                    $file = $request->file('answers')[$variable->id];
                    $path = $file->store('uploads', 'public');
                    $answers[$variable->id] = $path;
                }
            }

            // Update the response
            $response->update([
                'answers' => $answers
            ]);

            // Update dossier status if needed
            if ($dossier->task->is_last_task) {
                $dossier->update(['status' => 'termine']);
            } else {
                // Move to next task
                $nextTask = $dossier->procedure->tasks()
                    ->where('order', '>', $dossier->task->order)
                    ->orderBy('order')
                    ->first();

                if ($nextTask) {
                    $dossier->update([
                        'task_id' => $nextTask->id,
                        'status' => 'en_cours'
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.dossiers.show', $dossier)
                ->with('success', 'Réponses mises à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des réponses: ' . $e->getMessage());
        }
    }
}
