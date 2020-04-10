<?php

namespace Alimentalos\Relationships\Procedures;

use Alimentalos\Relationships\Models\Pet;

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
        $pet = Pet::create(array_merge(
                [
                    'photo_url' => config('storage.path') . 'photos/' . $photo->photo_url,
                    'user_uuid' => authenticated()->uuid,
                    'photo_uuid' => $photo->uuid,
                    'location' => parser()->pointFromCoordinates(input('coordinates')),
                ],
                request()->only(array_merge(
                        [
                            'name',
                            'description',
                            'born_at',
                            'size',
                            'is_public'
                        ],
                        Pet::getColors()
                    )
                )
            )
        );
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
        $pet->update(
            parameters()->fill(
                array_merge(
                    [
                        'name',
                        'description',
                        'born_at',
                        'size',
                        'is_public'
                    ],
                    Pet::getColors()
                ),
                $pet
            )
        );
        return $pet;
    }
}
