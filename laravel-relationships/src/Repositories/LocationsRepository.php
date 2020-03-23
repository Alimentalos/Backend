<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Lists\LocationList;
use Demency\Relationships\Procedures\LocationProcedure;
use Demency\Relationships\Queries\LocationQuery;

class LocationsRepository
{
    use LocationQuery;
    use LocationProcedure;
    use LocationList;
}
