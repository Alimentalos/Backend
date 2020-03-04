<?php

namespace App\Resources;

use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait UserResource
{
    /**
     * Get available user reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Follow';
    }

    /**
     * Update user validation rules.
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
     * Store user validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
    {
        return [
            'name' => 'required',
            'photo' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'is_public' => 'required|boolean',
            'coordinates' => ['required', new Coordinate()],
        ];
    }

    /**
     * Get user relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['photo', 'user'];
    }

    /**
     * Get user instances.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        if (!is_null($request->user('api')->user_uuid)) {
            return self::with('photo', 'user')->latest()->where([
                ['user_uuid', $request->user('api')->user_uuid]
            ])->orWhere([
                ['uuid', $request->user('api')->user_uuid]
            ])->paginate(20);
        } elseif ($request->user('api')->is_admin) {
            return self::with('photo', 'user')->latest()->paginate(20);
        } else {
            return self::with('photo', 'user')->latest()->where([
                ['user_uuid', $request->user()->uuid]
            ])->orWhere([
                ['uuid', $request->user('api')->uuid]
            ])->paginate(20);
        }
    }
}
