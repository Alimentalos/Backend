<?php

namespace App\Http\Controllers\Api\Near\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Users\IndexRequest;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $exploded = explode(',', $request->input('coordinates'));
        return response()->json(
            User::with('photo', 'user')->orderByDistance(
                'location',
                (new Point(floatval($exploded[0]), floatval($exploded[1]))),
                'asc'
            )->paginate(20),
            200
        );
    }
}
