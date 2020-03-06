<?php


namespace App\Resources;

use App\Alert;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait AlertResource
{
    /**
     * Update model via request.
     *
     * @return Alert
     */
    public function updateViaRequest()
    {
        return alerts()->updateViaRequest($this);
    }

    /**
     * Create alert via request.
     *
     * @return Alert
     */
    public function createViaRequest()
    {
        return alerts()->createViaRequest();
    }

    /**
     * Get available alert reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Support alert reactions
     * @body Increase code coverage support enabling the alert reactions. Just add routes and tests.
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update alert validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store alert validation rules.
     *
     * @return array
     */
    public function storeRules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'alert_type' => [
                'required',
                Rule::in(resources()->values())
            ],
            'alert_id' => [
                'required',
            ],
            'type' => [
                'required',
                Rule::in(alerts()->types())
            ],
            'status' => [
                'required',
                Rule::in(cataloger()->types())
            ],
            'photo' => 'required',
            'coordinates' => ['required', new Coordinate()],
        ];
    }

    /**
     * Get alert relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user', 'photo', 'alert'];
    }

    /**
     * Get alert instances.
     *
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return alerts()->index();
    }
}
