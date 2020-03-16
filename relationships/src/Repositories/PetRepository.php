<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Models\Pet;
use Demency\Relationships\Attributes\PetAttribute;
use Demency\Relationships\Procedures\PetProcedure;

class PetRepository
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
