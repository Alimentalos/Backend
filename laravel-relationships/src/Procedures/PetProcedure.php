<?php

namespace Demency\Relationships\Procedures;

use Demency\Relationships\Models\Pet;

trait PetProcedure
{
    /**
     * Create pet instance.
     *
     * @return Pet
     */
    public function createInstance()
    {
        $photo = photos()->create();
        $pet = Pet::create(array_merge([
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'description', 'hair_color', 'born_at', 'left_eye_color', 'right_eye_color', 'size', 'is_public')));
        $photo->pets()->attach($pet->uuid);
        return $pet;
    }

    /**
     * Update pet instance.
     *
     * @param Pet $pet
     * @return Pet
     */
    public function updateInstance(Pet $pet)
    {
        upload()->check($pet);
        $pet->update(parameters()->fill(['name', 'description', 'hair_color', 'born_at', 'left_eye_color', 'right_eye_color', 'size', 'is_public'], $pet));
        return $pet;
    }
}
