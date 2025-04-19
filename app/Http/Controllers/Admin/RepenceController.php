<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repence;
use App\Models\Variable;
use App\Models\User;
use App\Models\Agency;
use App\Models\Admin;
use Illuminate\Http\Request;

class RepenceController extends Controller
{
    public function index()
    {
        $repences = Repence::with(['variable', 'user', 'agency', 'admin'])->latest()->paginate(10);
        return view('admin.repences.index', compact('repences'));
    }

    public function create()
    {
        $variables = Variable::all();
        $users = User::all();
        $agencies = Agency::all();
        $admins = Admin::all();
        return view('admin.repences.create', compact('variables', 'users', 'agencies', 'admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'variable_id' => 'required|exists:variables,id',
            'user_id' => 'nullable|exists:users,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'admin_id' => 'nullable|exists:admins,id',
            'value' => 'required|string'
        ]);

        Repence::create($request->all());

        return redirect()->route('admin.repences.index')
            ->with('success', 'Réponse créée avec succès.');
    }

    public function show(Repence $repence)
    {
        return view('admin.repences.show', compact('repence'));
    }

    public function edit(Repence $repence)
    {
        $variables = Variable::all();
        $users = User::all();
        $agencies = Agency::all();
        $admins = Admin::all();
        return view('admin.repences.edit', compact('repence', 'variables', 'users', 'agencies', 'admins'));
    }

    public function update(Request $request, Repence $repence)
    {
        $request->validate([
            'variable_id' => 'required|exists:variables,id',
            'user_id' => 'nullable|exists:users,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'admin_id' => 'nullable|exists:admins,id',
            'value' => 'required|string'
        ]);

        $repence->update($request->all());

        return redirect()->route('admin.repences.index')
            ->with('success', 'Réponse mise à jour avec succès.');
    }

    public function destroy(Repence $repence)
    {
        $repence->delete();

        return redirect()->route('admin.repences.index')
            ->with('success', 'Réponse supprimée avec succès.');
    }
} 