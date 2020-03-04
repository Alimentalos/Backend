<?php


namespace App\Resources;

use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait GeofenceResource
{
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
        return $request->user('api')->is_child ? self::with('user', 'photo')->where(
            'user_uuid',
            $request->user('api')->user_uuid
        )->orWhere('is_public', true)->latest()->paginate(20) : self::with('user', 'photo')->where(
            'user_uuid',
            $request->user('api')->uuid
        )->orWhere('is_public', true)->latest()->paginate(20);
    }
}
