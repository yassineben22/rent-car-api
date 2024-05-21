<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;
use App\Models\User;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
        return response()->json($reservations, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_debut' => 'required|date_format:Y-m-d',
            'date_fin' => 'required|date_format:Y-m-d',
            'car_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs!'
            ], 400);
        }

        $fields = $request->validate([
            'date_debut' => 'required|date_format:Y-m-d',
            'date_fin' => 'required|date_format:Y-m-d',
            'car_id' => 'required|numeric',
        ]);

        $car = Car::find($fields['car_id']);
        $currentUser = auth()->user();

        if (!$car || !$currentUser) {
            return response()->json([
                'message' => 'Voiture ou utilisateur introuvable!'
            ], 404);
        }

        $reservation = Reservation::create([
            'date_debut' => $fields['date_debut'],
            'date_fin' => $fields['date_fin'],
            'car_id' => $fields['car_id'],
            'user_id' => $currentUser->id,
        ]);

        return response()->json($reservation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Réservation introuvable!'
            ], 404);
        }

        return response()->json($reservation, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'date_debut' => 'required|date_format:Y-m-d',
            'date_fin' => 'required|date_format:Y-m-d',
            'car_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs!'
            ], 400);
        }

        $fields = $request->validate([
            'date_debut' => 'required|date_format:Y-m-d',
            'date_fin' => 'required|date_format:Y-m-d',
            'car_id' => 'required|numeric',
        ]);

        $car = Car::find($fields['car_id']);
        $currentUser = auth()->user();

        if (!$car || !$currentUser) {
            return response()->json([
                'message' => 'Voiture ou utilisateur introuvable!'
            ], 404);
        }

        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Réservation introuvable!'
            ], 404);
        }

        $reservation->update([
            'date_debut' => $fields['date_debut'],
            'date_fin' => $fields['date_fin'],
            'car_id' => $fields['car_id'],
            'user_id' => $currentUser->id,
        ]);

        return response()->json($reservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Réservation introuvable!'
            ], 404);
        }

        $reservation->delete();

        return response()->json([
            'message' => 'Réservation supprimée avec succès!'
        ], 200);
    }
}
