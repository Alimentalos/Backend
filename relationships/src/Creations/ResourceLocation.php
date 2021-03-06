<?php


namespace Alimentalos\Relationships\Creations;


use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Events\Location as LocationEvent;
use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use App\Http\Resources\Location as LocationResource;
use Illuminate\Database\Eloquent\Model;

trait ResourceLocation
{
    /**
     * Update current model location.
     *
     * @param Resource $model
     * @return Resource
     */
    public function updateLocation(Resource $model)
    {
        $model->update([
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ]);
        if ($model instanceof Pet or $model instanceof User) {
            $location = $model->locations()->create([
                "uuid" => uuid(),
                "location" => parser()->pointFromCoordinates(input('coordinates')),
                "accuracy" => 20,
                'created_at' => now(),
                'updated_at' => now(),
                'generated_at' => now(),
            ]);

            geofences()->checkLocationUsingModelGeofences($model, $location);
            event(new LocationEvent(new LocationResource($location), $model));
        }
        return $model;
    }

    /**
     * Resolve current model for location insert.
     *
     * @return mixed
     */
    public function current()
    {
        $resource = explode('.', request()->route()->getName())[1];
        switch ($resource) {
            case 'device':
                return Device::where('uuid', authenticated()->uuid)->firstOrFail();
                break;
            case 'pet':
                return Pet::where('uuid', authenticated()->uuid)->firstOrFail();
                break;
            default:
                return User::where('uuid', authenticated()->uuid)->firstOrFail();
                break;
        }
    }

    /**
     * Create a device location.
     *
     * @param Model $model
     * @param $data
     * @return Model
     */
    public function createInstance(Model $model, $data)
    {
        if ($model instanceof User || $model instanceof Device) {
            return $model->locations()->create([
                "device" => $data["device"],
                "uuid" => $data["location"]["uuid"],
                "location" => parser()->point($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
                "altitude" => $data["location"]["coords"]["altitude"],
                "speed" => $data["location"]["coords"]["speed"],
                "heading" => $data["location"]["coords"]["heading"],
                "odometer" => $data["location"]["odometer"],
                "event" => parser()->event($data),
                "activity_type" => $data["location"]["activity"]["type"],
                "activity_confidence" => $data["location"]["activity"]["confidence"],
                "battery_level" => $data["location"]["battery"]["level"],
                "battery_is_charging" => $data["location"]["battery"]["is_charging"],
                "is_moving" => $data["location"]["is_moving"],
                "generated_at" => parser()->timestamp($data),
            ]);
        } else {
            return $model->locations()->create([
                "uuid" => $data["location"]["uuid"],
                "location" => parser()->point($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
            ]);
        }
    }
}
