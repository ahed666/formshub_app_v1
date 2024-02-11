<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefreshSignatue implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $account_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($account_id)
    {

        $this->account_id=$account_id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new Channel('refresh.'.$this->account_id);
    }

}
