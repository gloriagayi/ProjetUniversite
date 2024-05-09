<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Critere;
use App\Models\Rating;



class CritereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $criteres = Critere::all();

        return view('critere.index', compact('criteres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('critere.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'Nom' => 'required'
        ]);
    
        $critere = Critere::create($validatedData);
    
        return redirect('/critere')->with('success', 'critère créer avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $criteres = Critere::findOrFail($id);

        return view('critere.edit', compact('criteres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'Nom' => 'required|max:255'
        ]);
    
        Critere::whereId($id)->update($validatedData);
    
        return redirect('/critere')->with('success', 'Critere mise à jour avec succèss');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $critere = Critere::findOrFail($id);
        $critere->delete();
    
        return redirect('/critere')->with('success', 'critere supprimer avec succèss');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }
}
