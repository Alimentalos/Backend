<?php

namespace App\Resources;

use App\Group;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait GroupResource
{
    /**
     * Update group via request.
     *
     * @return Group
     */
    public function updateViaRequest()
    {
        return groups()->update($this);
    }

    /**
     * Create group via request.
     *
     * @return Group
     */
    public function createViaRequest()
    {
        return groups()->create();
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
     * @return array
     */
    public function updateRules()
    {
        return [
            'coordinates' => [
                Rule::requiredIf(fn() => request()->has('photo')),
                new Coordinate()
            ],
        ];
    }

    /**
     * Store group validation rules.
     *
     * @return array
     */
    public function storeRules()
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
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return authenticated()->is_admin ? groups()->all() : groups()->index();
    }
}
