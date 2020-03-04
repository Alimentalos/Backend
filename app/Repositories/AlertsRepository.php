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
     * @return Alert
     */
    public static function createAlertViaRequest(Request $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $alert_type = $request->input('alert_type');
        $alert = binder()::bindResourceInstance($alert_type, $request->input('alert_id'));
        $alert = Alert::create([
            'name' => $request->input('name'),
            'user_uuid' => $request->user('api')->uuid,
            'photo_uuid' => $photo->uuid,
            'alert_id' => $alert->uuid,
            'alert_type' => $alert_type,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates')),
        ]);
        $photo->alerts()->attach($alert->uuid);
        $alert->load('photo', 'user');
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
