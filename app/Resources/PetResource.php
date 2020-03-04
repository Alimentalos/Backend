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
     * @param Request $request
     * @return Pet
     */
    public function updateViaRequest(Request $request)
    {
        return PetsRepository::updatePetViaRequest($request, $this);
    }

    /**
     * Create pet via request.
     *
     * @param Request $request
     * @return Pet
     */
    public static function createViaRequest(Request $request)
    {
        return PetsRepository::createPetViaRequest($request);
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
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request)
    {
        return [
            'coordinates' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->has('photo');
                }), new Coordinate()
            ],
        ];
    }

    /**
     * Store pet validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
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
                    PetsRepository::SIZE_EXTRA_SMALL,
                    PetsRepository::SIZE_SMALL,
                    PetsRepository::SIZE_MEDIUM,
                    PetsRepository::SIZE_LARGE,
                    PetsRepository::SIZE_EXTRA_LARGE
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
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        return self::with('user', 'photo')->latest()->paginate(20);
    }
}
