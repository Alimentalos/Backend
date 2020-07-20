<?php

namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Rules\Coordinate;
use Alimentalos\Relationships\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait UserResource
{
    /**
     * Update user via request.
     *
     * @return User
     */
    public function updateViaRequest()
    {
        return users()->update($this);
    }

    /**
     * Create user via request.
     *
     * @return User
     */
    public function createViaRequest()
    {
        return users()->create();
    }

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
     * @return array
     */
    public function updateRules()
    {
        return [
            'coordinates' => [new Coordinate()],
        ];
    }

    /**
     * Store user validation rules.
     *
     * @return array
     */
    public function storeRules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'is_public' => 'required|boolean',
            'coordinates' => [new Coordinate()],
            'color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'border_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'background_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'text_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'marker_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
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
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        if (authenticated()->is_admin)
            return users()->all();

        return users()->index();
    }

    /**
     * Get is_admin custom attribute
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return admin()->isAdmin($this);
    }

    /**
     * Get is_child custom attribute.
     *
     * @return bool
     */
    public function getIsChildAttribute()
    {
        return !is_null($this->user_uuid);
    }
}
