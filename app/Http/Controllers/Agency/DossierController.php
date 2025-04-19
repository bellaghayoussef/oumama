<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Procedure;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('agency.dossiers.index')
            ->with('success', 'Dossier créé avec succès.');
    }

    public function show(Dossier $dossier)
    {
        $this->authorize('view', $dossier);
        return view('agency.dossiers.show', compact('dossier'));
    }

    public function edit(Dossier $dossier)
    {
        $this->authorize('update', $dossier);
        $procedures = Procedure::all();
        $users = User::all();
        $tasks = Task::all();
        return view('agency.dossiers.edit', compact('dossier', 'procedures', 'users', 'tasks'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $this->authorize('update', $dossier);
        
        $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'user_id' => 'required|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'status' => 'required|in:en_cours,en_attente,termine,rejete'
        ]);

        $dossier->update($request->all());

        return redirect()->route('agency.dossiers.index')
            ->with('success', 'Dossier mis à jour avec succès.');
    }

    public function destroy(Dossier $dossier)
    {
        $this->authorize('delete', $dossier);
        $dossier->delete();

        return redirect()->route('agency.dossiers.index')
            ->with('success', 'Dossier supprimé avec succès.');
    }
} 