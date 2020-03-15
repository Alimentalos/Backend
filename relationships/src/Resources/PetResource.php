<?php

namespace Demency\Relationships\Resources;

use App\Pet;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait PetResource
{
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
            'coordinates' => [
                Rule::requiredIf(fn() => request()->has('photo')),
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
            'hair_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'left_eye_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'right_eye_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'size' => [
                Rule::in([
                    pets()->size_extra_small,
                    pets()->size_small,
                    pets()->size_medium,
                    pets()->size_large,
                    pets()->size_extra_large,
                ])
            ],
            'born_at' => 'required',
            'coordinates' => ['required', new Coordinate()],
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
