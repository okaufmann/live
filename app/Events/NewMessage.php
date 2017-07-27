<?php

namespace App\Events;

use App\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $message;

    public $date;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param $message
     */
    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
        $this->date = Carbon::now()->toW3cString();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }
}
