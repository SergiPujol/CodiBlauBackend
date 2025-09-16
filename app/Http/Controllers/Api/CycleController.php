<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use Illuminate\Http\Request;
use App\Events\CycleStarted;

class CycleController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'rhythm_type' => 'required|string',
        ]);
        $lastNumber = Cycle::where('session_id', $sessionId)->max('number') ?? 0;

        $cycle = \App\Models\Cycle::create([
            'session_id' => $sessionId,
            'rhythm_type' => $validated['rhythm_type'],
            'start_time' => now(),
            'number' => $lastNumber + 1
        ]);

        broadcast(new CycleStarted($cycle))->toOthers();

        return response()->json([
            'id' => $cycle->id,
            'number' => $cycle->number,
        ], 201);
    }


}
