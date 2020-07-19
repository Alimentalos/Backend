<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Igaster\LaravelCities\Geo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReverseGeocodingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     * @codeCoverageIgnore 
     */
    public function __invoke(Request $request)
    {
        $cities = Geo::orderByDistance(
	        'location',
	        parser()->pointFromCoordinates(input('coordinates')),
	        'asc'
        )->paginate(25);
        return response()->json($cities, 200);
    }
}
