<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Find\IndexRequest;
use App\Http\Resources\LocationCollection;
use App\Repositories\LocationRepository;
use Illuminate\Http\JsonResponse;

class FindController extends Controller
{
    /**
     * Show current devices locations
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        // TODO - Reduce number of lines of FindController
        // @body move into repository method as searchLastsLocationsViaRequest.
        $locations = LocationRepository::searchLastLocations(
            $request->input('type'),
            $request->input('identifiers'),
            $request->input('accuracy')
        );

        return response()->json(
            new LocationCollection($locations->filter(function ($location) {
                return !is_null($location);
            })),
            200
        );
    }
}
