<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return response()->json($cars, 200);
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
            'photo' => 'required|string',
            'photoName' => 'required|string',
            'nom' => 'required|string',
            'carburant' => 'required|string',
            'matricule' => 'required|string',
            'prix' => 'required|numeric',
            'nombre_place' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs!'
            ], 400);
        }

        $fields = $request->validate([
            'photo' => 'required|string',
            'photoName' => 'required|string',
            'nom' => 'required|string',
            'carburant' => 'required|string',
            'matricule' => 'required|string',
            'prix' => 'required|numeric',
            'nombre_place' => 'required|numeric',
        ]);
        
        $namePhoto = time() . '' .$fields['photoName'];
        Storage::disk('public_uploads')->put($namePhoto, base64_decode($fields['photo']));

        $car = Car::create([
            'photo' => $namePhoto,
            'nom' => $fields['nom'],
            'carburant' => $fields['carburant'],
            'matricule' => $fields['matricule'],
            'prix' => $fields['prix'],
            'nombre_place' => $fields['nombre_place'],
        ]);
        
        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::find($id);
        if(!$car){
            return response()->json([
                'message' => 'Car not found!'
            ], 404);
        }
        return response()->json($car, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|string',
            'nom' => 'required|string',
            'carburant' => 'required|string',
            'matricule' => 'required|string',
            'prix' => 'required|numeric',
            'nombre_place' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs!'
            ], 400);
        }

        $fields = $request->validate([
            'photo' => 'required|string',
            'photoName' => 'required|string',
            'nom' => 'required|string',
            'carburant' => 'required|string',
            'matricule' => 'required|string',
            'prix' => 'required|numeric',
            'nombre_place' => 'required|numeric',
        ]);
        
        $namePhoto = time() . ' ' .$fields['photoName'];
        Storage::disk('public')->put($namePhoto, base64_decode($fields['photo']));

        $car = Car::find($id);
        if(!$car){
            return response()->json([
                'message' => 'Car not found!'
            ], 404);
        }
        $car->photo = $namePhoto;
        $car->nom = $fields['nom'];
        $car->carburant = $fields['carburant'];
        $car->matricule = $fields['matricule'];
        $car->prix = $fields['prix'];
        $car->nombre_place = $fields['nombre_place'];
        $car->save();
        
        return response()->json($car, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::find($id);
        if(!$car){
            return response()->json([
                'message' => 'Car not found!'
            ], 404);
        }
        $car->delete();
        return response()->json([
            'message' => 'Car deleted successfully!'
        ], 200);
    }
}
