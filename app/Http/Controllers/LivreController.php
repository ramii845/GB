<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    public function index()
    {
        try {
            // Charger les relations 'categorie' et 'auteur'
            $livres = Livre::with(['categorie', 'auteur'])->get();
            
            return response()->json($livres);
        } catch (\Exception $e) {
            return response()->json($e->getCode());
        }
    }
    
    

    /**
     * Store a newly created resource in storage.
     */public function store(Request $request)
{
   $livres = new Livre([
    'titre' => $request->input('titre'),
    'description' => $request->input('description'),
    "auteurID" => $request->input("auteurID"),
    
    
    'imagelivre' => $request->input('imagelivre'),
   
    'prix' => $request->input('prix'),
    'qteStock' => $request->input('qteStock'),

    'categorieID' => $request->input('categorieID'),
    ]);
   $livres->save();
    return response()->json('S/livre créée !');
    }


    
    public function show($id)
    {
    $livres = Livre::with('categorie')->findOrFail($id);
    return response()->json( $livres);
    }
    public function update(Request $request, $id)
    {
        $livres= Livre::find($id);
        $livres->update($request->all());
    return response()->json('S/livre Modifié !');
    }
    public function destroy($id)
    {
    $livres = Livre::findOrFail($id);
    $livres->delete();
    return response()->json('livre supprimée !');
    }
    
}