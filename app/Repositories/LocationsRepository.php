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
}
