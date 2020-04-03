<?php

namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Rules\Coordinate;
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
                Rule::requiredIf(function() {
                    return request()->has('photo');
                }),
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
            'color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'background_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'border_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'fill_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'text_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'user_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'administrator_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'owner_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
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
