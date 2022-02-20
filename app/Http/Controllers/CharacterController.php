<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{

    public function index(Request $request)
    {
        $characters = Character::where('user_id', $request->user()->id)->get();
        return response()->json($characters);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rank' => 'required',
            'skillpoints' => 'required',
            'health' => 'required',
            'attack' => 'required',
            'defense' => 'required',
            'magic' => 'required',
        ]);

        $countCharacters = Character::where('user_id', $request->user()->id)->count();

        if ($countCharacters >= 10) {
            return response()->json(["error" => "You can't have more than 10 characters"], 409);
        }

        $character = Character::create([
            'name' => $request->name,
            'rank' => $request->rank,
            'skillpoints' => $request->skillpoints,
            'health' => $request->health,
            'attack' => $request->attack,
            'defense' => $request->defense,
            'magic' => $request->magic,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($character);
    }

    public function show(Character $character)
    {
        return response()->json($character);
    }

    public function update(Request $request, Character $character)
    {
        $request->validate([
            'name' => 'required',
            'rank' => 'required',
            'skillpoints' => 'required',
            'health' => 'required',
            'attack' => 'required',
            'defense' => 'required',
            'magic' => 'required',
        ]);

        if ($character->user_id !== $request->user()->id) {
            return response()->json(["error" => "You can't edit this character"], 403);
        }

        $character->update([
            'name' => $request->name,
            'rank' => $request->rank,
            'skillpoints' => $request->skillpoints,
            'health' => $request->health,
            'attack' => $request->attack,
            'defense' => $request->defense,
            'magic' => $request->magic,
        ]);

        return response()->json($character);
    }

    public function destroy(Character $character)
    {
        if ($character->user_id != auth()->user()->id) {
            return response()->json(["error" => "You can't delete this character"], 403);
        }
        $character->delete();
        return response()->json(null, 204);
    }
}
