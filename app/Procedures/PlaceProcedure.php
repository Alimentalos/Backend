<?php


namespace App\Procedures;


use App\Place;

trait PlaceProcedure
{
    /**
     * Create pet instance.
     *
     * @return Place
     */
    public function createInstance()
    {
        $photo = photos()->create();
        $place = Place::create(array_merge([
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'description')));
        $photo->places()->attach($place->uuid);
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
        upload()->check($place);
        $place->update(parameters()->fill(['name', 'description'], $place));
        return $place;
    }
}
