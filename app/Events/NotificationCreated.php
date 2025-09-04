<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notification;
    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    // /**
    //  * Channel yang dipakai untuk broadcast.
    //  */
    // public function broadcastOn()
    // {
    //     // channel per-user
    //     return new PrivateChannel('user.' . $this->notification->user_id);
    // }

    // /**
    //  * Nama event di frontend.
    //  */
    // public function broadcastAs()
    // {
    //     return 'notification.created';
    // }
}
