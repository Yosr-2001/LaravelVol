<?php

namespace App\Http\Controllers;

use App\Models\Aeroport;
use Illuminate\Http\Request;

class AeroportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Aeroport::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'NomAeroport' => 'required|string|max:255',
                'VilleAeroport' => 'required|string|max:255',
                'PaysAeroport' => 'required|string|max:255',
            ]);

            $aeroport = Aeroport::create([
                'nom_aeroport' => $validated['NomAeroport'],
                'ville_aeroport' => $validated['VilleAeroport'],
                'pays_aeroport' => $validated['PaysAeroport'],
            ]);

            return response()->json($aeroport, 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Insertion impossible : {$e->getMessage()}"], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            return Aeroport::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(["message" => "Aéroport non trouvé : {$e->getMessage()}"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $aeroport = Aeroport::findOrFail($id);

            $validated = $request->validate([
                'NomAeroport' => 'nullable|string|max:255',
                'VilleAeroport' => 'nullable|string|max:255',
                'PaysAeroport' => 'nullable|string|max:255',
            ]);

            $aeroport->update([
                'nom_aeroport' => $validated['NomAeroport'] ?? $aeroport->nom_aeroport,
                'ville_aeroport' => $validated['VilleAeroport'] ?? $aeroport->ville_aeroport,
                'pays_aeroport' => $validated['PaysAeroport'] ?? $aeroport->pays_aeroport,
            ]);

            return response()->json($aeroport, 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Mise à jour impossible : {$e->getMessage()}"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $aeroport = Aeroport::findOrFail($id);
            $aeroport->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(["message" => "Suppression impossible : {$e->getMessage()}"], 400);
        }
    }
}
