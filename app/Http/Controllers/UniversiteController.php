<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Universite;
use App\Models\Rating;



class UniversiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universites = Universite::all();

        return view('universite.index', compact('universites'));
    }


    public function indexu()
    {
        $universites = Universite::all();

        return view('universite.indexu', compact('universites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('universite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Nom' => 'required',
            'Adresse' => 'required|max:255',
            'Informations_contact' => 'required|max:255',
            'Description' => 'required',
            'Programmes_etudes' => 'required',
            'Infrastructures' => 'required',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
    
        $universite = Universite::create($validatedData);

/*
        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);
        $universite->image = $fileName;


        --------
         if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('universite_images');
            $universite->update(['image' => $imagePath]);
        } */

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);


    
        return redirect('/universite')->with('success', 'Université créer avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $universites = Universite::findOrFail($id);
        return view('universite.show', compact('universites'));
    }

    public function showr(string $id)
    {
        //
        $universites = Universite::findOrFail($id);
        return view('universite.product', compact('universites'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $universites = Universite::findOrFail($id);

        return view('universite.edit', compact('universites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'Nom' => 'required|max:255',
            'adresse' => 'required',
            'Informations_contact' => 'required|max:255',
            'Description' => 'required',
            'Programmes_etudes' => 'required',
            'Infrastructures' => 'required',
            'Image' => 'nullable|image:jpeg,png,jpg,gif|max:2048',

        ]);
    
        Universite::whereId($id)->update($validatedData);
    
        return redirect('/universite')->with('success', 'Université mise à jour avec succèss');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $universite = Universite::findOrFail($id);
        $universite->delete();
    
        return redirect('/universite')->with('success', 'Université supprimer avec succèss');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

// Méthode pour afficher le classement
    public function showRanking()
    {
        $items = Universite::ranked();
        
        return view('dashboard', compact('items'));
    }

    public static function ranked()
    {
        /* return static::withCount('ratings')
            ->orderByRaw('(SELECT AVG(rating) FROM ratings WHERE product_id = universite.id) DESC')
            ->get();
 */


            $items = Universite::withCount('ratings')
            ->orderByRaw('(SELECT AVG(rating) FROM ratings WHERE product_id = universite.id) DESC')
            ->get();

        return $items;
    }
    
}
