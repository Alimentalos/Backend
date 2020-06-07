<?php

namespace Alimentalos\Relationships\Procedures;

use Alimentalos\Relationships\Models\Pet;

trait PetProcedure
{
    /**
     * Current pet properties
     *
     * @var string[]
     */
    protected $petProperties = [
        'name',
        'description',
        'born_at',
        'size',
        'is_public'
    ];

    /**
     * Create pet instance.
     *
     * @return Pet
     */
    public function createInstance()
    {
        $properties = [
            'user_uuid' => authenticated()->uuid,
        ];

        $fill = request()->only(
            array_merge(
                $this->petProperties,
                Pet::getColors()
            )
        );

        $pet = Pet::create(array_merge($properties, $fill)
        );
        upload()->checkPhoto($pet);
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
        upload()->checkPhoto($pet);
        fillAndUpdate($pet, $this->petProperties, Pet::getColors());
        return $pet;
    }
}
