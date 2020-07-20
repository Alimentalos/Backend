<?php


namespace Alimentalos\Relationships\Procedures;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\Photo;

trait AlertProcedure
{
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
            'photo_url' => config('storage.path') . 'photos/' . $photo->photo_url,
            'location' => rhas('coordinates') ? parser()->pointFromCoordinates(input('coordinates')) : null,
        ], only('name', 'title', 'body', 'type', 'status'));
    }

    /**
     * Create alert.
     *
     * @return Alert
     */
    public function createInstance()
    {
        $photo = photos()->create();
        $related = finder()->findInstance(input('alert_type'), input('alert_id'));
        $alert = Alert::create($this->parameters($photo, $related, input('alert_type')));
        $photo->alerts()->attach($alert->uuid);
        return $alert;
    }
}
