<?php

namespace App\Http\Controllers;

use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{

    public function index()
    {
        $fights = Fight::where('user_id', auth()->user()->id)->get();
        return response()->json($fights);
    }

    public function store(Request $request)
    {
        $request->validate([
            'playerCharacter' => 'required',
            'opponent' => 'required',
            'status' => 'required',
        ]);

        $fight = Fight::create([
            'playerCharacter' => $request->playerCharacter,
            'opponent' => $request->opponent,
            'status' => $request->status,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json($fight);
    }
}
