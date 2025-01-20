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
        return Vol::with(['aeroportDepart', 'aeroportArrivee'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'NumeroVol' => 'required|string|max:50',
                'HeureDepart' => 'required|date',
                'HeureArrivee' => 'required|date|after:HeureDepart',
                'Statut' => 'required|string|max:50',
                'Porte' => 'required|string|max:10',
                'prix' => 'nullable|numeric|min:0',
                'TypeAvion' => 'required|string|max:50',
                'IdAeroportDepart' => 'required|exists:aeroports,id',
                'IdAeroportArrivee' => 'required|exists:aeroports,id',
            ]);


            $vol = Vol::create([
                'numero_vol' => $validated['NumeroVol'],
                'heure_depart' => $validated['HeureDepart'],
                'heure_arrivee' => $validated['HeureArrivee'],
                'statut' => $validated['Statut'],
                'porte' => $validated['Porte'],
                'type_avion' => $validated['TypeAvion'],
                'prix' => $validated['prix'],

                'id_aeroport_depart' => $validated['IdAeroportDepart'],
                'id_aeroport_arrivee' => $validated['IdAeroportArrivee'],
            ]);

            return response()->json($vol, 201);
        } catch (\Exception $e) {
            return response()->json("Insertion impossible : {$e->getMessage()}", 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Vol::with(['aeroportDepart', 'aeroportArrivee'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $vol = Vol::findOrFail($id);

            $validated = $request->validate([
                'NumeroVol' => 'string|max:50',
                'HeureDepart' => 'date',
                'HeureArrivee' => 'date|after:HeureDepart',
                'Statut' => 'string|max:50',
                'Porte' => 'string|max:10',
                'TypeAvion' => 'string|max:50',
                'IdAeroportDepart' => 'exists:aeroports,id',
                'prix' => 'nullable|numeric|min:0',
                'IdAeroportArrivee' => 'exists:aeroports,id',
            ]);

            $vol->update([
                'numero_vol' => $validated['NumeroVol'] ?? $vol->numero_vol,
                'heure_depart' => $validated['HeureDepart'] ?? $vol->heure_depart,
                'heure_arrivee' => $validated['HeureArrivee'] ?? $vol->heure_arrivee,
                'statut' => $validated['Statut'] ?? $vol->statut,
                'porte' => $validated['Porte'] ?? $vol->porte,
                'type_avion' => $validated['TypeAvion'] ?? $vol->type_avion,
                'id_aeroport_depart' => $validated['IdAeroportDepart'] ?? $vol->id_aeroport_depart,

                'prix' => $validated['prix'] ?? $vol->prix,
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

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json("Suppression impossible : {$e->getMessage()}", 400);
        }
    }

    public function pagivate_search(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $departureCity = $request->input('departure');
        $destinationCity = $request->input('destination');

        $volsQuery = Vol::with(['aeroportDepart', 'aeroportArrivee']);

        if ($startDate) {
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
            $volsQuery->where('heure_depart', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();
            $volsQuery->where('heure_arrivee', '<=', $endDate);
        }

        if ($departureCity) {
            $volsQuery->whereHas('aeroportDepart', function ($query) use ($departureCity) {
                $query->where('ville_aeroport', 'like', '%' . $departureCity . '%');
            });
        }

        if ($destinationCity) {
            $volsQuery->whereHas('aeroportArrivee', function ($query) use ($destinationCity) {
                $query->where('ville_aeroport', 'like', '%' . $destinationCity . '%');
            });
        }
        $vols = $volsQuery->paginate(10);

        return response()->json($vols);
    }
}
