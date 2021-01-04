<?php


namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

trait AlertResource
{
    /**
     * Current alerts reactions
     *
     * @var string[]
     */
    protected $currentReactions = [
        'Love',
        'Pray',
        'Like',
        'Dislike',
        'Sad',
        'Hate'
    ];

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'uuid',
            'location',
            'user',
            'photo',
            'alert'
        ];
    }

    /**
     * Get available alerts reactions.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getAvailableReactions()
    {
        return implode(',', $this->currentReactions);
    }

    /**
     * Update model via request.
     *
     * @return Alert
     */
    public function updateViaRequest()
    {
        return alerts()->update($this);
    }

    /**
     * Create alert via request.
     *
     * @return Alert
     */
    public function createViaRequest()
    {
        return alerts()->create();
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
            'coordinates' => [new Coordinate()],
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
