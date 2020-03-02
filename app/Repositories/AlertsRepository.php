<?php


namespace App\Repositories;

use App\Alert;
use App\Photo;
use Illuminate\Http\Request;

class AlertsRepository
{
    /**
     * Create alert via request.
     *
     * @param Request $request
     * @param Photo $photo
     * @return Alert
     */
    public static function createAlertViaRequest(Request $request, Photo $photo)
    {
        $alert_type = $request->input('alert_type');
        $alert = HandleBindingRepository::bindResourceInstance($alert_type, $request->input('alert_id'));
        $alert = Alert::create([
            'name' => $request->input('name'),
            'photo_id' => $photo->id,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'user_id' => $request->user('api')->id,
            'alert_type' => $alert_type,
            'alert_id' => $alert->id,
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates')),
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
            'status' => FillRepository::fillMethod($request, 'status', $alert->status),
            'title' => FillRepository::fillMethod($request, 'title', $alert->title),
            'body' => FillRepository::fillMethod($request, 'body', $alert->body),
        ]);
        $alert->load('photo', 'user', 'alert');
        return $alert;
    }

    public static function availableAlertTypes()
    {
        return [
            'App\\User',
            'App\\Device',
            'App\\Pet',
        ];
    }
}
