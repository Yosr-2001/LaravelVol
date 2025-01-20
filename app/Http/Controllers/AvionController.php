<?php

namespace App\Http\Controllers;

use App\Models\Avion;
use Illuminate\Http\Request;

class AvionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Avion::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'TypeAvion' => 'required|string|max:255',
                'CapaciteAvion' => 'required|integer|min:1',
                'FabriquantAvion' => 'nullable|string|max:255',
            ]);

            $avion = Avion::create([
                'type_avion' => $validated['TypeAvion'],
                'capacite_avion' => $validated['CapaciteAvion'],
                'fabriquant_avion' => $validated['FabriquantAvion'] ?? null,
            ]);

            return response()->json($avion, 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Insertion impossible : {$e->getMessage()}"], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Avion::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $avion = Avion::findOrFail($id);

            $validated = $request->validate([
                'type_avion' => 'nullable|string|max:255',
                'capacite_avion' => 'nullable|integer|min:1',
                'fabriquant_avion' => 'nullable|string|max:255',
            ]);

            $avion->update([
                'type_avion' => $validated['type_avion'] ?? $avion->type_avion,
                'capacite_avion' => $validated['capacite_avion'] ?? $avion->capacite_avion,
                'fabriquant_avion' => $validated['fabriquant_avion'] ?? $avion->fabriquant_avion,
            ]);

            return response()->json($avion, 200);
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
            $avion = Avion::findOrFail($id);
            $avion->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(["message" => "Suppression impossible : {$e->getMessage()}"], 400);
        }
    }
}
