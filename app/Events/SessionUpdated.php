<?php

// app/Events/SessionUpdated.php
namespace App\Events;

use App\Models\Session;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SessionUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session->toArray();
    }

    public function broadcastOn()
    {
        return new Channel('session.'.$this->session['id']);
    }

    public function broadcastAs()
    {
        return 'SessionUpdated';
    }
}

