<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formuler;
use App\Models\Task;
use Illuminate\Http\Request;

class FormulerController extends Controller
{
    public function index()
    {
        $formulers = Formuler::with('task')->latest()->paginate(10);
        return view('admin.formulers.index', compact('formulers'));
    }

    public function create()
    {
        $tasks = Task::all();
        return view('admin.formulers.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'task_id' => 'required|exists:tasks,id'
        ]);

        Formuler::create($request->all());

        return redirect()->route('admin.formulers.index')
            ->with('success', 'Formulaire créé avec succès.');
    }

    public function show(Formuler $formuler)
    {
        return view('admin.formulers.show', compact('formuler'));
    }

    public function edit(Formuler $formuler)
    {
        $tasks = Task::all();
        return view('admin.formulers.edit', compact('formuler', 'tasks'));
    }

    public function update(Request $request, Formuler $formuler)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'task_id' => 'required|exists:tasks,id'
        ]);

        $formuler->update($request->all());

        return redirect()->route('admin.formulers.index')
            ->with('success', 'Formulaire mis à jour avec succès.');
    }

    public function destroy(Formuler $formuler)
    {
        $formuler->delete();

        return redirect()->route('admin.formulers.index')
            ->with('success', 'Formulaire supprimé avec succès.');
    }
} 