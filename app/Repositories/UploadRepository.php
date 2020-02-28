<?php


namespace App\Repositories;


use Grimzy\LaravelMysqlSpatial\Types\Point;
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

            $exploded = explode(',', $request->input('coordinates'));

            $model->update([
                'photo_id' => $photo->id,
                'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
                'location' => (new Point(
                    floatval($exploded[0]),
                    floatval($exploded[1])
                )),
            ]);

            $model->photos()->attach($photo->id);
        }

    }
}
