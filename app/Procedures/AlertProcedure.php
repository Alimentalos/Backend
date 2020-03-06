<?php


namespace App\Procedures;


use App\Photo;

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
            'photo_url' => config('storage.path') . $photo->photo_url,
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'title', 'body', 'type', 'status'));
    }
}
