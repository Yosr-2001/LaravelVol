<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use Illuminate\Http\Request;

class PassagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Passager::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'NomPassager' => 'required|string|max:255',
                'PrenomPassager' => 'required|string|max:255',
                'EmailPassager' => 'required|email|max:255|unique:passagers,email_passager',
                'DateNaissance' => 'required|date',
                'TelephonePassager' => 'required|string|max:15',
                'NumeroPasseport' => 'required|string|max:20|unique:passagers,numero_passeport',
            ]);
            $passager = Passager::create([
                'nom_passager' => $validated['NomPassager'],         // Mapping avec la colonne 'nom_passager'
                'prenom_passager' => $validated['PrenomPassager'],   // Mapping avec la colonne 'prenom_passager'
                'email_passager' => $validated['EmailPassager'],     // Mapping avec la colonne 'email_passager'
                'date_naissance' => $validated['DateNaissance'],     // Mapping avec la colonne 'date_naissance'
                'telephone_passager' => $validated['TelephonePassager'], // Mapping avec la colonne 'telephone_passager'
                'numero_passeport' => $validated['NumeroPasseport'], // Mapping avec la colonne 'numero_passeport'
            ]);

            return response()->json($passager, 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Insertion impossible : {$e->getMessage()}"], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Passager::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $passager = Passager::findOrFail($id);

            $validated = $request->validate([
                'NomPassager' => 'nullable|string|max:255',
                'PrenomPassager' => 'nullable|string|max:255',
                'EmailPassager' => 'nullable|email|max:255|unique:passagers,email_passager,' . $id,
                'DateNaissance' => 'nullable|date',
                'TelephonePassager' => 'nullable|string|max:15',
                'NumeroPasseport' => 'nullable|string|max:20|unique:passagers,numero_passeport,' . $id,
            ]);

            $passager->update([
                'nom_passager' => $validated['NomPassager'] ?? $passager->nom_passager,
                'prenom_passager' => $validated['PrenomPassager'] ?? $passager->prenom_passager,
                'email_passager' => $validated['EmailPassager'] ?? $passager->email_passager,
                'date_naissance' => $validated['DateNaissance'] ?? $passager->date_naissance,
                'telephone_passager' => $validated['TelephonePassager'] ?? $passager->telephone_passager,
                'numero_passeport' => $validated['NumeroPasseport'] ?? $passager->numero_passeport,
            ]);

            return response()->json($passager, 200);
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
            $passager = Passager::findOrFail($id);
            $passager->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(["message" => "Suppression impossible : {$e->getMessage()}"], 400);
        }
    }
}
