<?php


namespace App\Resources;

use App\Geofence;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait GeofenceResource
{
    /**
     * Update model via request.
     *
     * @return Geofence
     */
    public function updateViaRequest()
    {
        return geofences()->update($this);
    }

    /**
     * Create model via request.
     *
     * @return Geofence
     */
    public function createViaRequest()
    {
        return geofences()->create();
    }

    /**
     * Get available geofence reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Follow';
    }

    /**
     * Update geofence validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [
            'coordinates' => [
                Rule::requiredIf(function () {
                    return request()->has('photo');
                }), new Coordinate()
            ],
        ];
    }

    /**
     * Store geofence validation rules.
     *
     * @return array
     */
    public function storeRules()
    {
        return [
            'name' => 'required',
            'photo' => 'required',
            'shape.*.latitude' => 'required_with:shape.*.longitude',
            'is_public' => 'required|boolean',
            'coordinates' => ['required', new Coordinate()],
        ];
    }

    /**
     * Get geofence relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user', 'photo'];
    }

    /**
     * Get geofence instances.
     *
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return authenticated()->is_child ? geofences()->getChildGeofences() : geofences()->getOwnerGeofences();
    }
}
