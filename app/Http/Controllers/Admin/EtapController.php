<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etap;
use App\Models\Procedure;
use Illuminate\Http\Request;

class EtapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etaps = Etap::with('procedure')->latest()->paginate(10);
        return view('admin.etaps.index', compact('etaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $procedures = Procedure::all();
        return view('admin.etaps.create', compact('procedures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'procedure_id' => 'required|exists:procedures,id',
            'delait' => 'required|integer|min:1'
        ]);

        Etap::create($request->all());

        return redirect()->route('admin.etaps.index')
            ->with('success', 'Étape créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etap $etap)
    {
        return view('admin.etaps.show', compact('etap'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etap $etap)
    {
        $procedures = Procedure::all();
        return view('admin.etaps.edit', compact('etap', 'procedures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etap $etap)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'procedure_id' => 'required|exists:procedures,id',
            'delait' => 'required|integer|min:1'
        ]);

        $etap->update($request->all());

        return redirect()->route('admin.etaps.index')
            ->with('success', 'Étape mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etap $etap)
    {
        $etap->delete();

        return redirect()->route('admin.etaps.index')
            ->with('success', 'Étape supprimée avec succès.');
    }
}
