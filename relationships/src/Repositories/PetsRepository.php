<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Attributes\PetAttribute;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Procedures\PetProcedure;

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
