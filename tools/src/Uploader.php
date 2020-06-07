<?php


namespace Alimentalos\Tools;


use Alimentalos\Contracts\Resource;

class Uploader
{
    /**
     * Check if request has a model photo pending to upload.
     *
     * @param Resource $model
     */
    public function checkPhoto(Resource $model)
    {
        if (rhas('photo')) {
            $photo = photos()->create();
            $model->update([
                'photo_uuid' => $photo->uuid,
                'photo_url' => config('storage.path') . 'photos/' . $photo->photo_url,
                'location' => parser()->pointFromCoordinates(input('coordinates')),
            ]);
            $model->photos()->attach($photo->uuid);
        }

    }


    /**
     * Check if request has a model marker pending to upload.
     *
     * @param Resource $model
     */
    public function checkMarker(Resource $model)
    {
        if (rhas('marker')) {
            $uuid = uuid();
            photos()->storePhoto($uuid, uploaded('marker'));
            $model->update([
                'marker' => config('storage.path') . 'markers/' . ($uuid . '.' . uploaded('marker')->extension())
            ]);
        }
    }
}
