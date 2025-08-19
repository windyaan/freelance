<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Channel spesifik per chat
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.' . $this->message->chat_id);
    }

    /**
     * Data yang dikirim ke frontend
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message->content,
            'sender_id' => $this->message->sender_id,
            'chat_id' => $this->message->chat_id,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
