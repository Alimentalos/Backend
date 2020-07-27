<?php


namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
            'coordinates' => [new Coordinate()],
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
            'shape.*.latitude' => 'required_with:shape.*.longitude',
            'is_public' => 'required|boolean',
            'coordinates' => [new Coordinate()],
            'color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'border_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'background_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'text_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'fill_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'tag_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'marker_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
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
