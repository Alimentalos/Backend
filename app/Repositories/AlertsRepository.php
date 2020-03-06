<?php


namespace App\Repositories;

use App\Alert;
use App\Photo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
            ->whereIn('status',rhas('whereInStatus') ?
                    einput(',','whereInStatus') : status()->values()
            )->latest('created_at')
            ->paginate(25);
    }

    /**
     * Create alert via request.
     *
     * @return Alert
     */
    public function createViaRequest()
    {
        $photo = photos()->createViaRequest();
        $related = finder()->findInstance(input('alert_type'), input('alert_id'));
        $alert = Alert::create($this->parameters($photo, $related, input('alert_type')));
        $photo->alerts()->attach($alert->uuid);
        $alert->load('photo', 'user');
        return $alert;
    }

    /**
     * Generate parameters.
     *
     * @param Photo $photo
     * @param $alert
     * @param $alert_type
     * @return array
     */
    public function parameters(Photo $photo, $alert, $alert_type)
    {
        return array_merge([
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'alert_id' => $alert->uuid,
            'alert_type' => $alert_type,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'title', 'body', 'type', 'status'));
    }

    /**
     * Update alert via request.
     *
     * @param Alert $alert
     * @return Alert
     */
    public function updateViaRequest(Alert $alert)
    {
        upload()->check($alert);
        $alert->update(parameters()->fill(['type', 'status', 'title', 'body'], $alert));
        $alert->load('photo', 'user', 'alert');
        return $alert;
    }


    /**
     * Get available alert types.
     *
     * @return array
     */
    public function types()
    {
        return [
            'App\\User',
            'App\\Device',
            'App\\Pet',
        ];
    }
}
