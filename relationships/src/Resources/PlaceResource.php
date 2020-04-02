<?php

namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait PlaceResource
{
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
            'coordinates' => [
                Rule::requiredIf(function () {
                    return request()->has('photo');
                }),
                new Coordinate()
            ],
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
            'photo' => 'required',
            'is_public' => 'required|boolean',
            'coordinates' => ['required', new Coordinate()],
            'color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'marker_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
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
