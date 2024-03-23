<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $message;
    private string $received_id;
    private string $sender_id;

    /**
     * Create a new event instance.
     * @param string $message $
     * @param string $received_id $
     */
    public function __construct(string $message, string $received_id)
    {

        $this->message = $message;
        $this->received_id = $received_id;
        $this->sender_id = auth()->id();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->received_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'Chat'; // App\Event\ChatEvent
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'received_id' => $this->received_id
        ];
    }
}
