<?php


namespace App\Repositories;

use App\Alert;
use App\Photo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class AlertsRepository
{
    /**
     * Get alerts.
     *
     * @return LengthAwarePaginator
     */
    public function getAlerts()
    {
        return Alert::with('user', 'photo', 'alert')
            ->whereIn(
                'status',
                request()->has('whereInStatus') ?
                    explode(',', request()->input('whereInStatus')) : StatusRepository::availableAlertStatuses() // Filter by statuses
            )->latest('created_at')->paginate(25);
    }

    /**
     * Create alert via request.
     *
     * @param Request $request
     * @return Alert
     */
    public static function createViaRequest(Request $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $related = finder()->findInstance($request->input('alert_type'), $request->input('alert_id'));
        $obj = Alert::create(static::buildCreateParameters($request, $photo, $related, $request->input('alert_type')));
        $photo->alerts()->attach($obj->uuid);
        $obj->load('photo', 'user');
        return $obj;
    }

    /**
     * Build create parameters.
     *
     * @param Request $request
     * @param Photo $photo
     * @param $alert
     * @param $alert_type
     * @return array
     */
    public static function buildCreateParameters(Request $request, Photo $photo, $alert, $alert_type)
    {
        return array_merge([
            'user_uuid' => $request->user('api')->uuid,
            'photo_uuid' => $photo->uuid,
            'alert_id' => $alert->uuid,
            'alert_type' => $alert_type,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'location' => LocationsRepository::parsePointFromCoordinates($request->input('coordinates')),
        ], $request->only('name', 'title', 'body', 'type', 'status'));
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
        $alert->update(ParametersRepository::fillPropertiesWithRelated($request, ['type', 'status', 'title', 'body'], $alert));
        $alert->load('photo', 'user', 'alert');
        return $alert;
    }


    /**
     * Get available alert types.
     *
     * @return array
     */
    public function getAvailableAlertTypes()
    {
        return [
            'App\\User',
            'App\\Device',
            'App\\Pet',
        ];
    }
}
