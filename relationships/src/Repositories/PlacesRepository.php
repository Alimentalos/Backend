<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Procedures\PlaceProcedure;

class PlacesRepository
{
    use PlaceProcedure;

    /**
     * Create place.
     *
     * @return Place
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update pet.
     *
     * @param Place $place
     * @return Place
     */
    public function update(Place $place)
    {
        return $this->updateInstance($place);
    }
}
