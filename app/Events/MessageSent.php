<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
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
    public function broadcastOn()
    {
    // return new Channel('chat');
    return new PrivateChannel('chat.' . $this->message->chat_id);
    }

    //nama event yg diterima frontend
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    /**
     * Data yang dikirim ke frontend
     */
    public function broadcastWith()
    {
        return [
            // 'id' => $this->message->id,
            // 'message' => $this->message->content,
            // 'sender_id' => $this->message->sender_id,
            // 'sender_name' => $this->message->sender->name ?? 'Unknown',
            // 'sender_avatar' => $this->message->sender->profile->avatar_url ?? null,
            // 'chat_id' => $this->message->chat_id,
            // 'created_at' => $this->message->created_at->toDateTimeString(),
            'id'        => $this->message->id,
            'chat_id'   => $this->message->chat_id,
            'sender_id' => $this->message->sender_id,
            'content'   => $this->message->content,
            'created_at'=> $this->message->created_at->toISOString(),
        ];
    }
}
