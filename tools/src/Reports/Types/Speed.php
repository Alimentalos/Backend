<?php

namespace Alimentalos\Tools\Reports\Types;

use App\Http\Resources\LocationCollection;

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
            ->where('speed', '<=', measurer()->transformKilometersToMeters($this->parameters['max']))
            ->where('speed', '>=', measurer()->transformKilometersToMeters($this->parameters['min']))
            ->get();

        return new LocationCollection($locations);
    }
}
