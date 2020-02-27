<?php

namespace App\Http\Controllers\Api\Near\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Pets\IndexRequest;
use App\Pet;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $exploded = explode(',', $request->input('coordinates'));
        return response()->json(
            Pet::with('photo', 'user')->orderByDistance(
                'location',
                (new Point(floatval($exploded[0]), floatval($exploded[1]))),
                'asc'
            )->paginate(20),
            200
        );
    }
}
