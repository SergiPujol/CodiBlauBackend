<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $session = Session::create([
            'rhythm_type' => $request->rhythm_type,
            'start_time' => $request->start_time,
        ]);

        $lastNumber = Cycle::where('session_id', $session->id)->max('number') ?? 0;

        $cycle = Cycle::create([
            'session_id' => $session->id,
            'rhythm_type' => $session->rhythm_type,
            'started_at' => $session->start_time,
            'number' => $lastNumber + 1
        ]);

        return response()->json([
            'id' => $session->id,
            'cycle_id' => $cycle->id,
            'start_time' => $session->start_time,
        ]);
    }

    public function show($id)
    {
        $session = Session::with('actions')->findOrFail($id);
        return response()->json($session);
    }
}
