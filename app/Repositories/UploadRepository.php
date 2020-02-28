<?php


namespace App\Repositories;


use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UploadRepository
{
    public static function checkPhotoForUpload(Request $request, Model $model)
    {
        if ($request->has('photo')) {
            $photo = PhotoRepository::createPhoto(
                $request->user('api'),
                $request->file('photo'),
                null,
                null,
                FillRepository::fillMethod($request, 'is_public', $model->is_public),
                $request->input('coordinates')
            );

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
