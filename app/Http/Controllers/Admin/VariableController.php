<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variable;
use App\Models\Formuler;
use Illuminate\Http\Request;

class VariableController extends Controller
{
    public function index()
    {
        $variables = Variable::with('formuler')->latest()->paginate(10);
        return view('admin.variables.index', compact('variables'));
    }

    public function create()
    {
        $formulers = Formuler::all();
        return view('admin.variables.create', compact('formulers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:string,bool,number,file',
            'formuler_id' => 'required|exists:formulers,id'
        ]);

        Variable::create($request->all());

        return redirect()->route('admin.variables.index')
            ->with('success', 'Variable créée avec succès.');
    }

    public function show(Variable $variable)
    {
        return view('admin.variables.show', compact('variable'));
    }

    public function edit(Variable $variable)
    {
        $formulers = Formuler::all();
        return view('admin.variables.edit', compact('variable', 'formulers'));
    }

    public function update(Request $request, Variable $variable)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:string,bool,number,file',
            'formuler_id' => 'required|exists:formulers,id'
        ]);

        $variable->update($request->all());

        return redirect()->route('admin.variables.index')
            ->with('success', 'Variable mise à jour avec succès.');
    }

    public function destroy(Variable $variable)
    {
        $variable->delete();

        return redirect()->route('admin.variables.index')
            ->with('success', 'Variable supprimée avec succès.');
    }
} 