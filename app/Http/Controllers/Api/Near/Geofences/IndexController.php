<?php

namespace App\Http\Controllers\Api\Near\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Geofences\IndexRequest;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $exploded = explode(',', $request->input('coordinates'));
        return response()->json(
            Geofence::with('photo', 'user')->orderByDistance(
                'shape',
                (new Point(floatval($exploded[0]), floatval($exploded[1]))),
                'asc'
            )->paginate(20),
            200
        );
    }
}
