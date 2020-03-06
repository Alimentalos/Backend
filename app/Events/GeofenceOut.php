<?php

namespace App\Events;

use App\Geofence;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GeofenceOut implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var Model $location
     */
    public $location;

    /**
     * @var Geofence $geofence
     */
    public $geofence;

    /**
     * @var Model $model
     */
    public $model;

    /**
     * @var string $type
     */
    public $type;

    /**
     * Create a new event.
     *
     * @param Model $location
     * @param Geofence $geofence
     * @param Model $model
     */
    public function __construct(Model $location, Geofence $geofence, Model $model)
    {
        $this->location = $location;
        $this->geofence = $geofence;
        $this->model = $model;
        $this->type = $this->location->trackable_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel("geofences." . $this->geofence->uuid);
    }
}
