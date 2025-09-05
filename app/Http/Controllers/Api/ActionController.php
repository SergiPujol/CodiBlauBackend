<?php

namespace App\Http\Controllers\Api;

use App\Events\ActionRegistered;
use App\Http\Controllers\Controller;
use App\Models\Action;
use Illuminate\Http\Request;

class
ActionController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        // Validació de dades
        $validated = $request->validate([
            'cycle_id' => 'required|integer|exists:cycles,id',
            'type' => 'required|string|max:255',
            'executed_at' => 'nullable|date',
        ]);

        // Crear acció
        $action = Action::create([
            'session_id' => $sessionId,
            'cycle_id' => $validated['cycle_id'],
            'type' => $validated['type'],
            'executed_at' => now(),
            ]);

        $action->refresh();

        \Log::info('✅ Acció creada correctament:', $action->toArray());
        \Log::info('📡 Emissió via WebSocket:', [
            'session_id' => $action->session_id,
            'type' => $action->type,
        ]);

        // Emetre event
        broadcast(new ActionRegistered($action))->toOthers();

        return response()->json([
            'message' => 'Acció registrada i emesa correctament',
            'action' => $action,
        ], 201);
    }

    public function list($sessionId)
    {
        $actions = Action::where('session_id', $sessionId)
            ->orderBy('executed_at', 'asc')
            ->get();

        return response()->json($actions);
    }

}
