<?php

namespace App\Repositories;

use App\Pet;
use App\Photo;
use Illuminate\Http\Request;

class PetsRepository
{

    /**
     * Size "Extra Small"
     */
    public const SIZE_EXTRA_SMALL = 'xs';

    /**
     * Size "Small".
     */
    public const SIZE_SMALL = 's';

    /**
     * Size "Medium".
     */
    public const SIZE_MEDIUM = 'm';

    /**
     * Size "Large".
     */
    public const SIZE_LARGE = 'l';

    /**
     * Size "Extra small".
     */
    public const SIZE_EXTRA_LARGE = 'xl';

    /**
     * Update pet via request.
     *
     * @param Request $request
     * @param Pet $pet
     * @return Pet
     */
    public static function updatePetViaRequest(Request $request, Pet $pet)
    {
        UploadRepository::checkPhotoForUpload($request, $pet);
        $pet->update(ParametersRepository::fillPropertiesWithRelated($request, ['name', 'description', 'hair_color', 'born_at', 'left_eye_color', 'right_eye_color', 'size', 'is_public'], $pet));
        $pet->load('photo', 'user');
        return $pet;
    }

    /**
     * Create pet via request.
     *
     * @param Request $request
     * @param Photo $photo
     * @return Pet
     */
    public static function createPetViaRequest(Request $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $pet = Pet::create(array_merge([
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_uuid' => $request->user('api')->uuid,
            'photo_uuid' => $photo->uuid,
            'location' => LocationsRepository::parsePointFromCoordinates($request->input('coordinates')),
        ], $request->only('name', 'description', 'hair_color', 'born_at', 'left_eye_color', 'right_eye_color', 'size', 'is_public')));
        $photo->pets()->attach($pet->uuid);
        $pet->load('user', 'photo');
        return $pet;
    }
}
