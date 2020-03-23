<?php

namespace Alimentalos\Relationships\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Location implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $location;

    public $trackable;

    /**
     * Create a new event.
     *
     * @param $location
     */
    public function __construct($location, $trackable)
    {
        $this->location = $location;
        $this->trackable = $trackable;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PresenceChannel("locations." . $this->location->trackable_type . "." . $this->trackable->uuid);
    }
}
