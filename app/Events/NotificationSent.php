<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        // kirim ke channel khusus user penerima
        return new PrivateChannel('notifications.' . $this->notification->user_id);
    }

    public function broadcastWith()
    {
        return [
            'id'      => $this->notification->id,
            'type'    => $this->notification->type,
            'content' => $this->notification->content,
            'link'    => $this->notification->link_url,
            'created_at' => $this->notification->created_at->toDateTimeString(),
        ];
    }
}
