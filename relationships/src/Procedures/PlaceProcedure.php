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
        // Check photo uploaded
        $photo = photos()->create();

        // Marker
        $marker_uuid = uuid();
        photos()->storePhoto($marker_uuid, uploaded('marker'));

        // Attributes
        $place = Place::create(
            array_merge(
                [
                    'photo_url' => config('storage.path') . 'photos/' . $photo->photo_url,
                    'user_uuid' => authenticated()->uuid,
                    'photo_uuid' => $photo->uuid,
                    'location' => parser()->pointFromCoordinates(input('coordinates')),
                    'marker' => config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension()),
                ],
                request()->only(
                    array_merge(
                        [
                            'name',
                            'description',
                        ],
                        Place::getColors()
                    )
                )
            )
        );

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
        // Check photo uploaded
        upload()->check($place);

        // Marker
        if (rhas('marker')) {
            $marker_uuid = uuid();
            photos()->storePhoto($marker_uuid, uploaded('marker'));
            $place->update([
                'marker' => config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension())
            ]);
        }

        // Attributes
        $place->update(
            parameters()->fill(
                array_merge(
                    [
                        'name',
                        'description',
                    ],
                    Place::getColors()
                ),
                $place
            )
        );
        return $place;
    }
}
