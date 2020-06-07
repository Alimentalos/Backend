<?php


namespace Alimentalos\Relationships\Procedures;


use Alimentalos\Relationships\Models\Place;

trait PlaceProcedure
{
    /**
     * Create pet instance.
     *
     * @return Place
     */
    public function createInstance()
    {
        $properties = [
            'user_uuid' => authenticated()->uuid,
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ];

        $fill = request()->only(array_merge(['name', 'description'], Place::getColors()));

        // Attributes
        $place = Place::create(array_merge($properties, $fill));

        // Photo
        upload()->checkPhoto($place);

        // Marker
        upload()->checkMarker($place);

        return $place;
    }

    /**
     * Update pet instance.
     *
     * @param Place $place
     * @return Place
     */
    public function updateInstance(Place $place)
    {
        // Check photo uploaded
        upload()->checkPhoto($place);

        // Marker
        upload()->checkMarker($place);

        // Attributes
        fillAndUpdate($place, ['name', 'description'], Place::getColors());
        return $place;
    }
}
