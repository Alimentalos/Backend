<?php


namespace Alimentalos\Tools;


use App\Contracts\Resource;

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
            $data = [];
            if (rhas('coordinates')) {
            	$data['location'] = parser()->pointFromCoordinates(input('coordinates'));
            }
            $data['photo_uuid'] = $photo->uuid;
            $data['photo_url'] = config('storage.path') . 'photos/' . $photo->photo_url;
            $model->update($data);
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
