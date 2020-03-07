<?php

namespace App\Repositories;

use App\Attributes\PetAttribute;
use App\Pet;
use App\Procedures\PetProcedure;

class PetsRepository
{
    use PetProcedure;
    use PetAttribute;

    /**
     * Create pet.
     *
     * @return Pet
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update pet.
     *
     * @param Pet $pet
     * @return Pet
     */
    public function update(Pet $pet)
    {
        return $this->updateInstance($pet);
    }
}
