<?php

namespace App\Http\Controllers\Api\Near\Resource;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Resource\IndexRequest;
use App\Pet;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $exploded = explode(',', $request->input('coordinates'));
        switch ($resource) {
            case 'geofences':
                return response()->json(
                    Geofence::with('photo', 'user')->orderByDistance(
                        'shape',
                        (new Point(floatval($exploded[0]), floatval($exploded[1]))),
                        'asc'
                    )->paginate(20),
                    200
                );
                break;
            case 'users':
                return response()->json(
                    User::with('photo', 'user')->orderByDistance(
                        'location',
                        (new Point(floatval($exploded[0]), floatval($exploded[1]))),
                        'asc'
                    )->paginate(20),
                    200
                );
                break;
            default:
                return response()->json(
                    Pet::with('photo', 'user')->orderByDistance(
                        'location',
                        (new Point(floatval($exploded[0]), floatval($exploded[1]))),
                        'asc'
                    )->paginate(20),
                    200
                );
                break;
        }
    }
}
