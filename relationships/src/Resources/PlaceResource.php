<?php

namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait PlaceResource
{
    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'uuid',
            'location',
            'user_uuid',
            'photo_uuid',
            'photo_url',
            'is_public',
            'name',
            'description',
            'created_at',
            'updated_at',
            'love_reactant_id',
            'photo',
        ];
    }

    /**
     * Update pet via request.
     *
     * @return Place
     */
    public function updateViaRequest()
    {
        return places()->update($this);
    }

    /**
     * Create pet via request.
     *
     * @return Place
     */
    public static function createViaRequest()
    {
        return places()->create();
    }

    /**
     * Get available pet reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update pet validation rules.
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
     * Store pet validation rules.
     *
     * @return array
     */
    public function storeRules()
    {
        return [
            'name' => 'required',
            'is_public' => 'required|boolean',
            'coordinates' => [new Coordinate()],
            'color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'marker_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
        ];
    }

    /**
     * Get pet relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['photo', 'user'];
    }

    /**
     * Get pet instances.
     *
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return Place::latest()->paginate(20);
    }
}
