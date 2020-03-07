<?php


namespace App\Repositories;

use App\Contracts\Resource;
use App\Geofence;
use App\Lists\GeofenceAccessesList;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GeofenceAccessesRepository
{
    use GeofenceAccessesList;
}
