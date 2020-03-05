<?php

namespace App\Resources;

use App\Pet;
use App\Repositories\PetsRepository;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
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
        return pets()->updatePetViaRequest($this);
    }

    /**
     * Create pet via request.
     *
     * @return Pet
     */
    public static function createViaRequest()
    {
        return pets()->createPetViaRequest();
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
                    pets()::SIZE_EXTRA_SMALL,
                    pets()::SIZE_SMALL,
                    pets()::SIZE_MEDIUM,
                    pets()::SIZE_LARGE,
                    pets()::SIZE_EXTRA_LARGE
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
        return Pet::with('user', 'photo')->latest()->paginate(20);
    }
}
