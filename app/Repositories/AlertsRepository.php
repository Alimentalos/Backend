<?php


namespace App\Repositories;

use App\Alert;
use App\Pet;
use App\Photo;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

class AlertsRepository
{
    /**
     * Create alert via request
     *
     * @param Request $request
     * @param Photo $photo
     * @return mixed
     */
    public static function createAlertViaRequest(Request $request, Photo $photo)
    {
        $exploded = explode(',', $request->input('coordinates'));
        $alert = Alert::create([
            'name' => $request->input('name'),
            'photo_id' => $photo->id,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_id' => $request->user('api')->id,
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'type' => $request->input('type'),
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
        ]);
        $photo->alerts()->attach($alert->id);
        return $alert;
    }

    /**
     * Update alert via request.
     *
     * @param Request $request
     * @param Alert $alert
     * @return Alert
     */
    public static function updateAlertViaRequest(Request $request, Alert $alert)
    {
        UploadRepository::checkPhotoForUpload($request, $alert);
        $alert->update([
            'type' => FillRepository::fillMethod($request, 'type', $alert->type),
            'title' => FillRepository::fillMethod($request, 'title', $alert->title),
            'body' => FillRepository::fillMethod($request, 'body', $alert->body),
        ]);
        $alert->load('photo', 'user');
        return $alert;
    }
}
