<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        // TODO - Remove unnecessary complexity
        $geofences = $request->user('api')->is_child ? Geofence::with('user', 'photo')->where(
            'user_id',
            $request->user('api')->user_id
        )->orWhere('is_public', true)->latest()->paginate(20) : Geofence::with('user', 'photo')->where(
            'user_id',
            $request->user('api')->id
        )->orWhere('is_public', true)->latest()->paginate(20);
        return response()->json(
            $geofences,
            200
        );
    }
}
