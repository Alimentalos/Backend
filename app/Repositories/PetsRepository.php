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
     * @param Pet $pet
     * @return Pet
     */
    public function updatePetViaRequest(Pet $pet)
    {
        UploadRepository::check($pet);
        $pet->update(parameters()->fill(['name', 'description', 'hair_color', 'born_at', 'left_eye_color', 'right_eye_color', 'size', 'is_public'], $pet));
        $pet->load('photo', 'user');
        return $pet;
    }

    /**
     * Create pet via request.
     *
     * @return Pet
     */
    public function createPetViaRequest()
    {
        $photo = photos()->createPhotoViaRequest();
        $pet = Pet::create(array_merge([
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'description', 'hair_color', 'born_at', 'left_eye_color', 'right_eye_color', 'size', 'is_public')));
        $photo->pets()->attach($pet->uuid);
        $pet->load('user', 'photo');
        return $pet;
    }
}
