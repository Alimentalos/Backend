<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UploadRepository
{
    /**
     * Check if request has a model photo pending to upload.
     *
     * @param Request $request
     * @param Model $model
     */
    public static function checkPhotoForUpload(Request $request, Model $model)
    {
        if ($request->has('photo')) {
            $photo = PhotoRepository::createPhotoViaRequest($request);
            $model->update([
                'photo_uuid' => $photo->uuid,
                'photo_url' => config('storage.path') . $photo->photo_url,
                'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates')),
            ]);
            $model->photos()->attach($photo->uuid);
        }

    }
}
