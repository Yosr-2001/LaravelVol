<?php

namespace App\Http\Controllers;

use App\Models\Vol;
use Illuminate\Http\Request;

class VolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne tous les vols avec les relations des aéroports associés
        return Vol::with(['aeroportDepart', 'aeroportArrivee'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données d'entrée
            $validated = $request->validate([
                'NumeroVol' => 'required|string|max:50',
                'HeureDepart' => 'required|date',
                'HeureArrivee' => 'required|date|after:HeureDepart',
                'Statut' => 'required|string|max:50',
                'Porte' => 'required|string|max:10',
                'TypeAvion' => 'required|string|max:50',
                'IdAeroportDepart' => 'required|exists:aeroports,id',
                'IdAeroportArrivee' => 'required|exists:aeroports,id',
            ]);

            // Création du vol avec les données validées
            $vol = Vol::create([
                'numero_vol' => $validated['NumeroVol'],
                'heure_depart' => $validated['HeureDepart'],
                'heure_arrivee' => $validated['HeureArrivee'],
                'statut' => $validated['Statut'],
                'porte' => $validated['Porte'],
                'type_avion' => $validated['TypeAvion'],
                'id_aeroport_depart' => $validated['IdAeroportDepart'],
                'id_aeroport_arrivee' => $validated['IdAeroportArrivee'],
            ]);

            return response()->json($vol, 201); // Retourne le vol créé avec un code 201

        } catch (\Exception $e) {
            return response()->json("Insertion impossible : {$e->getMessage()}", 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retourne un vol spécifique avec ses relations
        return Vol::with(['aeroportDepart', 'aeroportArrivee'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $vol = Vol::findOrFail($id);

            // Validation des données d'entrée
            $validated = $request->validate([
                'NumeroVol' => 'string|max:50',
                'HeureDepart' => 'date',
                'HeureArrivee' => 'date|after:HeureDepart',
                'Statut' => 'string|max:50',
                'Porte' => 'string|max:10',
                'TypeAvion' => 'string|max:50',
                'IdAeroportDepart' => 'exists:aeroports,id',
                'IdAeroportArrivee' => 'exists:aeroports,id',
            ]);

            // Mise à jour des champs validés
            $vol->update([
                'numero_vol' => $validated['NumeroVol'] ?? $vol->numero_vol,
                'heure_depart' => $validated['HeureDepart'] ?? $vol->heure_depart,
                'heure_arrivee' => $validated['HeureArrivee'] ?? $vol->heure_arrivee,
                'statut' => $validated['Statut'] ?? $vol->statut,
                'porte' => $validated['Porte'] ?? $vol->porte,
                'type_avion' => $validated['TypeAvion'] ?? $vol->type_avion,
                'id_aeroport_depart' => $validated['IdAeroportDepart'] ?? $vol->id_aeroport_depart,
                'id_aeroport_arrivee' => $validated['IdAeroportArrivee'] ?? $vol->id_aeroport_arrivee,
            ]);

            return response()->json($vol, 200);
        } catch (\Exception $e) {
            return response()->json("Mise à jour impossible : {$e->getMessage()}", 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $vol = Vol::findOrFail($id);
            $vol->delete();

            return response()->noContent(); // Retourne un code 204 pour une suppression réussie
        } catch (\Exception $e) {
            return response()->json("Suppression impossible : {$e->getMessage()}", 400);
        }
    }
}
