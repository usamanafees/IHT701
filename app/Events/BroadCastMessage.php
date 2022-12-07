<?php

namespace App\Events;
use Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadCastMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $cid;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$cid)
    {
        $this->message = $message;
        $this->cid = $cid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        echo "yupyaaaaaaaaaa";
        return new PrivateChannel('home.'.$this->cid);
    }
    // public function broadcastAs()
    // {
    //     return 'my-event';
    // }
}