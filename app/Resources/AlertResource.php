<?php


namespace App\Resources;

use App\Repositories\ResourceRepository;
use App\Repositories\StatusRepository;
use App\Repositories\TypeRepository;
use App\Rules\Coordinate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait AlertResource
{
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
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store alert validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'alert_type' => [
                'required',
                Rule::in(ResourceRepository::availableResource())
            ],
            'alert_id' => [
                'required',
            ],
            'type' => [
                'required',
                Rule::in(TypeRepository::availableAlertTypes())
            ],
            'status' => [
                'required',
                Rule::in(StatusRepository::availableAlertStatuses())
            ],
            'photo' => 'required',
            'coordinates' => ['required', new Coordinate()],
        ];
    }
}
