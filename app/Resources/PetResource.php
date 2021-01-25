<?php

namespace App\Resources;

use App\Models\Pet;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait PetResource
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
            'hair_color',
            'left_eye_color',
            'size',
            'born_at',
            'is_public',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Update pet via request.
     *
     * @return Pet
     */
    public function updateViaRequest()
    {
        return pets()->update($this);
    }

    /**
     * Create pet via request.
     *
     * @return Pet
     */
    public static function createViaRequest()
    {
        return pets()->create();
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
            'hair_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'left_eye_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'right_eye_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'size' => [
                'required',
                Rule::in([
                    pets()->size_extra_small,
                    pets()->size_small,
                    pets()->size_medium,
                    pets()->size_large,
                    pets()->size_extra_large,
                ])
            ],
            'born_at' => 'required',
            'coordinates' => [new Coordinate()],
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
        return Pet::latest()->paginate(20);
    }
}
