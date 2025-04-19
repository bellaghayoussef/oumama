<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Procedure;
use App\Models\Agency;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

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

        Dossier::create($request->all());

        return redirect()->route('admin.dossiers.index')
            ->with('success', 'Dossier créé avec succès.');
    }

    public function show(Dossier $dossier)
    {
        return view('admin.dossiers.show', compact('dossier'));
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
} 