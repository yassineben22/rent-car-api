<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs!'
            ], 400);
        }

        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $fields['username'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect!'
            ], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'role' => $user->role
        ], 200);
    }

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'telephone' => 'required|string',
            'cin' => 'required|string',
            'num_permis' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs!'
            ], 400);
        }

        $fields = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'telephone' => 'required|string',
            'cin' => 'required|string',
            'num_permis' => 'required|string',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => 'user',
            'telephone' => $fields['telephone'],
            'cin' => $fields['cin'],
            'num_permis' => $fields['num_permis'],
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'role' => $user->role
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie!'
        ], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $user->reservations;
        return response()->json($user, 200);
    }
}
