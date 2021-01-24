<?php

namespace Alimentalos\Relationships\Resources;

use App\Models\User;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait UserResource
{
    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'email',
            'email_verified_at',
            'free',
            'photo_url',
            'location',
            'is_public',
            'created_at',
            'updated_at',
            'love_reactant_id',
            'love_reacter_id',
            'is_admin',
            'is_child',
            'user',
            'photo',
        ];
    }

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
