<?php

namespace Alimentalos\Relationships\Procedures;

use App\Models\Pet;

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
        $properties = request()->only(
            array_merge($this->petProperties, Pet::getColors())
        );

        $pet = Pet::create($properties);
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
