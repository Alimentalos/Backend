<?php

namespace App\Reports\Types;

use App\Http\Resources\LocationCollection;
use App\Repositories\SpeedRepository;

class Speed extends Type
{

    /**
     * Get Speed report as Array
     *
     * @return LocationCollection
     */
    public function toArray()
    {
        $locations = $this->getFilterableQuery()
            ->where('speed', '<=', SpeedRepository::transformKilometersToMeters($this->parameters['max']))
            ->where('speed', '>=', SpeedRepository::transformKilometersToMeters($this->parameters['min']))
            ->get();

        return new LocationCollection($locations);
    }
}
