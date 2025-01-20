<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Reservation::with(['vol', 'passager'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'IdPassager' => 'required|exists:passagers,id',
                'IdVol' => 'required|exists:vols,id',
                'DateReservation' => 'required|date',
                'StatutReservation' => 'required|string|max:50',
                'PrixReservation' => 'required|numeric|min:0',
            ]);

            $reservation = Reservation::create([
                'id_passager' => $validated['IdPassager'],
                'id_vol' => $validated['IdVol'],
                'date_reservation' => $validated['DateReservation'],
                'statut_reservation' => $validated['StatutReservation'],
                'prix_reservation' => $validated['PrixReservation'],
            ]);

            return response()->json($reservation, 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Insertion impossible : {$e->getMessage()}"], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Reservation::with(['vol', 'passager'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            $validated = $request->validate([
                'IdPassager' => 'exists:passagers,id',
                'IdVol' => 'exists:vols,id',
                'DateReservation' => 'date',
                'StatutReservation' => 'string|max:50',
                'PrixReservation' => 'numeric|min:0',
            ]);

            $reservation->update([
                'id_passager' => $validated['IdPassager'] ?? $reservation->id_passager,
                'id_vol' => $validated['IdVol'] ?? $reservation->id_vol,
                'date_reservation' => $validated['DateReservation'] ?? $reservation->date_reservation,
                'statut_reservation' => $validated['StatutReservation'] ?? $reservation->statut_reservation,
                'prix_reservation' => $validated['PrixReservation'] ?? $reservation->prix_reservation,
            ]);

            return response()->json($reservation, 200);
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
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(["message" => "Suppression impossible : {$e->getMessage()}"], 400);
        }
    }
    public function getHistoriqueReservationsByEmail($email)
    {
        $reservations = Reservation::whereHas('passager', function ($query) use ($email) {
            $query->where('email_passager', $email);
        })
            ->with(['vol', 'vol.aeroportDepart', 'vol.aeroportArrivee'])
            ->get();

        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'Aucune réservation trouvée pour cet email.'], 404);
        }

        return response()->json($reservations, 200);
    }
}
