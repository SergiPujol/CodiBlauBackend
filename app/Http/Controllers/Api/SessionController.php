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

    public function index(Request $request)
    {
        $query = Session::query();

        if ($request->has('active') && $request->active == 1) {
            $query->whereNull('end_time');
        }

        if ($request->has('finished') && $request->finished == 1) {
            $query->whereNotNull('end_time');
        }

        $sessions = $query->orderBy('start_time', 'desc')->get();

        return response()->json($sessions);
    }

    public function show($id)
    {
        $session = Session::with(['actions', 'cycles'])->findOrFail($id);
        return response()->json($session);
    }

    public function update(Request $request, $id)
    {
        $session = Session::findOrFail($id);

        if ($request->has('end_time')) {
            $session->end_time = now();
            $session->save();
        }

        return response()->json([
            'message' => 'Sessió actualitzada correctament',
            'session' => $session
        ]);
    }

    public function close(Request $request, $id)

    {
        $session = Session::findOrFail($id);
        $session->end_time = now();
        $session->save();

        return response()->json($session);
    }
}
