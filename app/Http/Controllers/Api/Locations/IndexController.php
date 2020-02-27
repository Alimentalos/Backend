<?php

namespace App\Http\Controllers\Api\Locations;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Locations\IndexRequest;
use App\Http\Resources\LocationCollection;
use App\Pet;
use App\Repositories\LocationRepository;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        // TODO - Remove unnecessary complexity
        switch ($request->input('type')) {
            case 'users':
                $models = User::whereIn('uuid', explode(',', $request->input('identifiers')))->get();
                break;
            case 'pets':
                $models = Pet::whereIn('uuid', explode(',', $request->input('identifiers')))->get();
                break;
            default:
                $models = Device::whereIn('uuid', explode(',', $request->input('identifiers')))->get();
                break;
        }

        $locations = LocationRepository::searchLocations( // Search locations
            $request->input('type'),
            $models, // of those devices
            $request->input('start_date'), // between an start date
            $request->input('end_date'), // and end date
            $request->input('accuracy') // filtering by accuracy
        );

        return response()->json(
            new LocationCollection($locations),
            200
        );
    }
}
