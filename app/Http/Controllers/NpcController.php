<?php

namespace App\Http\Controllers;

use App\Models\Npc;
use Illuminate\Http\Request;

class NpcController extends Controller
{
    public function index(Request $request)
    {
        $npcs = Npc::where('user_id', $request->user()->id)->get();
        return response()->json($npcs);
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

        $countNpcs = Npc::where('user_id', $request->user()->id)->count();

        if ($countNpcs >= 10) {
            return response()->json(["error" => "You can't have more than 10 npcs"], 409);
        }

        $npc = Npc::create([
            'name' => $request->name,
            'rank' => $request->rank,
            'skillpoints' => $request->skillpoints,
            'health' => $request->health,
            'attack' => $request->attack,
            'defense' => $request->defense,
            'magic' => $request->magic,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($npc);
    }

    public function show(Npc $npc)
    {
        return response()->json($npc);
    }

    public function update(Request $request, Npc $npc)
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

        if ($npc->user_id !== $request->user()->id) {
            return response()->json(["error" => "You can't edit this npc"], 403);
        }

        $npc->update([
            'name' => $request->name,
            'rank' => $request->rank,
            'skillpoints' => $request->skillpoints,
            'health' => $request->health,
            'attack' => $request->attack,
            'defense' => $request->defense,
            'magic' => $request->magic,
        ]);

        return response()->json($npc);
    }

    public function destroy(Npc $npc)
    {
        if ($npc->user_id != auth()->user()->id) {
            return response()->json(["error" => "You can't delete this npc"], 403);
        }
        $npc->delete();
        return response()->json(null, 204);
    }
}
