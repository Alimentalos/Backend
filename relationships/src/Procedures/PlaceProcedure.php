<?php


namespace Alimentalos\Relationships\Procedures;


use App\Models\Place;

trait PlaceProcedure
{
    /**
     * Current place properties.
     *
     * @var string[]
     */
    protected $placeProperties = [
        'name',
        'description'
    ];

    /**
     * Create pet instance.
     *
     * @return Place
     */
    public function createInstance()
    {
        $properties = [
            'location' => rhas('coordinates') ? parser()->pointFromCoordinates(input('coordinates')) : null,
        ];

        $fill = request()->only(
            array_merge($this->placeProperties, Place::getColors())
        );

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
        // Check photo and marker uploaded
        upload()->checkPhoto($place);
        upload()->checkMarker($place);
        fillAndUpdate($place, $this->placeProperties, Place::getColors());
        return $place;
    }
}
