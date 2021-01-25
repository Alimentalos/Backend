<?php

namespace App\Resources;

use App\Models\Group;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait GroupResource
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
            'description',
            'is_public',
            'photo_url',
            'created_at',
            'updated_at',
        ];
    }

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
     * @codeCoverageIgnore
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
            'coordinates' => [new Coordinate()],
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
            'is_public' => 'required|boolean',
            'color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'background_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'border_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'fill_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'text_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'user_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'administrator_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'owner_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'coordinates' => [new Coordinate()],
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
