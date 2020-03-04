<?php


namespace App\Resources;

use App\Geofence;
use App\Repositories\GeofenceRepository;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait GeofenceResource
{
    /**
     * Update model via request.
     *
     * @param Request $request
     * @return Geofence
     */
    public function updateViaRequest(Request $request)
    {
        return GeofenceRepository::updateGeofenceViaRequest($request, $this);
    }

    /**
     * Create model via request.
     *
     * @param Request $request
     * @return Geofence
     */
    public function createViaRequest(Request $request)
    {
        return GeofenceRepository::createGeofenceViaRequest($request);
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
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request)
    {
        return [
            'coordinates' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->has('photo');
                }), new Coordinate()
            ],
        ];
    }

    /**
     * Store geofence validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
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
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        return authenticated()->is_child ? geofences()->getChildGeofences() : geofences()->getOwnerGeofences();
    }
}
