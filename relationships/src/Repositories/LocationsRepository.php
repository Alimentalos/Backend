<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Lists\LocationList;
use Alimentalos\Relationships\Procedures\LocationProcedure;
use Alimentalos\Relationships\Queries\LocationQuery;

class LocationsRepository
{
    use LocationQuery;
    use LocationProcedure;
    use LocationList;
}
