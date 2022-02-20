<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "error" => "Wrong credentials"
            ], 401);
        }

        $user->tokens()->where('tokenable_id',  $user->id)->delete();

        $token = $user->createToken($request->device_name)->plainTextToken;


        return response()->json([
            "token" => $token,
            "user" => $user,
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $exists = User::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json(["error" => "User already registed"], 409);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            "token" => $token,
            "user" => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        $hasSuccedded = $request->user()->currentAccessToken()->delete();


        if ($hasSuccedded) {
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Could not logout user because he was not authenticated'], 401);
    }
}
