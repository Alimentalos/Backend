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
        $pet->update([
            'name' => FillRepository::fillMethod($request, 'name', $pet->name),
            'description' => FillRepository::fillMethod($request, 'description', $pet->description),
            'hair_color' => FillRepository::fillMethod($request, 'hair_color', $pet->hair_color),
            'born_at' => FillRepository::fillMethod($request, 'born_at', $pet->born_at),
            'left_eye_color' => FillRepository::fillMethod($request, 'left_eye_color', $pet->left_eye_color),
            'right_eye_color' => FillRepository::fillMethod($request, 'right_eye_color', $pet->right_eye_color),
            'size' => FillRepository::fillMethod($request, 'size', $pet->size),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $pet->is_public),
        ]);
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
    public static function createPetViaRequest(Request $request, Photo $photo)
    {
        $pet = Pet::create([
            'name' => $request->input('name'),
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_id' => $request->user('api')->id,
            'description' => $request->input('description'),
            'hair_color' => $request->input('hair_color'),
            'born_at' => $request->input('born_at'),
            'photo_id' => $photo->id,
            'left_eye_color' => $request->input('left_eye_color'),
            'right_eye_color' => $request->input('right_eye_color'),
            'size' => $request->input('size'),
            'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates')),
            'is_public' => $request->input('is_public')
        ]);
        $photo->pets()->attach($pet->id);
        return $pet;
    }
}
