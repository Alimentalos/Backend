<?php

namespace App\Repositories;

use App\Lists\LocationList;
use App\Procedures\LocationProcedure;
use App\Queries\LocationQuery;

class LocationsRepository
{
    use LocationQuery;
    use LocationProcedure;
    use LocationList;

    /**
     * Longitude position.
     */
    public const LATITUDE = 0;

    /**
     * Latitude position.
     */
    public const LONGITUDE = 1;
}
