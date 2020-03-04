<?php

namespace App\Resources;

use App\Group;
use App\Repositories\GroupsRepository;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait GroupResource
{
    /**
     * Update group via request.
     *
     * @param Request $request
     * @return Group
     */
    public function updateViaRequest(Request $request)
    {
        return GroupsRepository::updateGroupViaRequest($request, $this);
    }

    /**
     * Create group via request.
     *
     * @param Request $request
     * @return Group
     */
    public function createViaRequest(Request $request)
    {
        return GroupsRepository::createGroupViaRequest($request);
    }

    /**
     * Get available group reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Support group reactions
     * @body Increase code coverage support enabling the group reactions. Just add routes and tests.
     */
    public function getAvailableReactions()
    {
        return 'Follow';
    }

    /**
     * Update group validation rules.
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
     * Store group validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
    {
        return [
            'name' => 'required',
            'photo' => 'required',
            'is_public' => 'required|boolean',
            'coordinates' => ['required', new Coordinate()],
        ];
    }

    /**
     * Get group relationships using lady loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['photo', 'user'];
    }

    /**
     * Get group instances.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        return (
        $request->user('api')->is_admin ?
            self::with('user', 'photo') :
            self::with('user', 'photo')->where('user_uuid', $request->user('api')->uuid)
                ->orWhere('is_public', true)
                ->orWhereIn('uuid', $request->user('api')->groups->map(function($group) { return $group->uuid; }))
        )->latest()->paginate(25);
    }
}
