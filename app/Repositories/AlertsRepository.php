<?php


namespace App\Repositories;

use App\Alert;
use App\Lists\AlertList;
use App\Procedures\AlertProcedure;

class AlertsRepository
{
    use AlertList;
    use AlertProcedure;

    /**
     * Lost type.
     */
    public const LOST = 0;

    /**
     * Dead type.
     */
    public const DEAD = -1;

    /**
     * Found type.
     */
    public const FOUND = 1;

    /**
     * Available alert types.
     *
     * @return array
     */
    public function types()
    {
        return [
            self::FOUND,
            self::DEAD,
            self::LOST,
        ];
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
    public function alert_types()
    {
        return [
            'App\\User',
            'App\\Device',
            'App\\Pet',
        ];
    }
}
