<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UploadRepository
{
    /**
     * Check if request has a model photo pending to upload.
     *
     * @param Model $model
     */
    public static function checkPhotoForUpload(Model $model)
    {
        if (request()->has('photo')) {
            $photo = photos()->createPhotoViaRequest();
            $model->update([
                'photo_uuid' => $photo->uuid,
                'photo_url' => config('storage.path') . $photo->photo_url,
                'location' => parser()->pointFromCoordinates(input('coordinates')),
            ]);
            $model->photos()->attach($photo->uuid);
        }

    }
}
