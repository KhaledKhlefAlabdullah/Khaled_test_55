<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $receivers;
    protected $message;

    /**
     * Create a new event instance.
     */
    public function __construct($receivers,$message)
    {
        // todo comlete here tommoro to send the send notification in reake time by send event on wensockets
        $this->receivers = $receivers;
        $this->message = $message;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $chanels = [];
        foreach($this->receivers as $receiver){
            array_push($chanels,new PrivateChannel('Notificatio-to-user-id'.$receiver->id));
        }
        
        return $chanels;
    }
}
