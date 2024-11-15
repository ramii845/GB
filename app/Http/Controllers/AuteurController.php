<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {

        try{

            $auteur=Auteur::all();
            return response()->json($auteur);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des auteurs: ' . $e->getMessage());
            return response()->json([
                'message' => 'Impossible d\'afficher les données',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        
            $auteur = Auteur::create([
                "imageAuteur" => $request->input("imageAuteur"),
                "nomAuteur" => $request->input("nomAuteur"),
                
                "descriptionAuteur" => $request->input("descriptionAuteur"),
                
            ]);
    
            return response()->json($auteur, 201);
    
        } catch (\Exception $e) {
        
            return response()->json(['message' => 'Problème d\'ajout'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)

    {
        try{
          $auteur=Auteur::findOrFail($id);
          return response()->json(($auteur));


    } catch(\Exception $e){
        return response()->json("probléme d'affichage");
  }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $auteur=Auteur::findOrFail($id);
            $auteur->update($request->all());
            return response()->json($auteur);

        
    }catch(\Exception $e){
        return response()->json("modification impossible");
  }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $auteur=Auteur::findOrFail($id);
            $auteur->delete();
            return response()->json(("Auteur supprimer avec succés"));

        } catch(\Exception $e){
            return response()->json("probléme de suppression");
      }
    }
}