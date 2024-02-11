<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceRefresh implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
     public $url;
     public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($url,$id)
    {
        //

        $this->id=$id;
        $this->url=$url;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new Channel('refresh.'.$this->id);
    }

}
