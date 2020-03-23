<?php


namespace Demency\Tools;


use Demency\Contracts\Resource;

class Uploader
{
    /**
     * Check if request has a model photo pending to upload.
     *
     * @param Resource $model
     */
    public function check(Resource $model)
    {
        if (request()->has('photo')) {
            $photo = photos()->create();
            $model->update([
                'photo_uuid' => $photo->uuid,
                'photo_url' => config('storage.path') . $photo->photo_url,
                'location' => parser()->pointFromCoordinates(input('coordinates')),
            ]);
            $model->photos()->attach($photo->uuid);
        }

    }
}
