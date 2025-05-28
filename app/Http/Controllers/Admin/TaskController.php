<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Etap;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('etap')->latest()->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etaps = Etap::all();
        return view('admin.tasks.create', compact('etaps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'etap_id' => 'required|exists:etaps,id',
            'intervenant' => 'required|in:admin,agence,user',
            'delait' => 'required|integer|min:1',
            'order' => 'required'
        ]);

        Task::create($request->all());

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tâche créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $etaps = Etap::all();
        return view('admin.tasks.edit', compact('task', 'etaps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'etap_id' => 'required|exists:etaps,id',
            'intervenant' => 'required|in:admin,agence,user',
            'delait' => 'required|integer|min:1',
              'order' => 'required'
        ]);

        $task->update($request->all());

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tâche mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tâche supprimée avec succès.');
    }
}
