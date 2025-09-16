<?php

namespace App\Events;

use App\Models\Cycle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CycleStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cycle;

    public function __construct(Cycle $cycle)
    {
        $this->cycle = $cycle;
    }

    public function broadcastOn()
    {
        return new Channel('session.' . $this->cycle->session_id);
    }

    public function broadcastAs()
    {
        return 'cyclestarted';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->cycle->id,
            'number' => $this->cycle->number,
            'session_id' => $this->cycle->session_id,
            'started_at' => $this->cycle->created_at,
            'rhythm_type' => $this->cycle->rhythm_type,
        ];
    }
}
