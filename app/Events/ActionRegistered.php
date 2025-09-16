<?php

namespace App\Events;

use App\Models\Action;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionRegistered implements ShouldBroadcast
{
    use Dispatchable,InteractsWithSockets, SerializesModels;

    public $action;

    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('session.' . $this->action->session_id);
    }
    public function broadcastWith()
    {
        return [
            'id' => $this->action->id,
            'type' => $this->action->type,
            'executed_at' => $this->action->executed_at,
            'session_id' => $this->action->session_id,
            'cycle_id' => $this->action->cycle_id,
            'cycle_number' => $this->action->cycle->number,
        ];
    }

    public function broadcastAs()
    {
        return 'actionregistered';
    }
}
