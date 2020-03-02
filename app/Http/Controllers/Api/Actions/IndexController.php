<?php

namespace App\Http\Controllers\Api\Actions;

use App\Action;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Actions\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        if (!$request->user('api')->is_child) {
            return response()->json(
                Action::whereIn('user_id', $request->user('api')
                    ->users
                    ->pluck('id')
                    ->push(
                        $request->user('api')->id
                    )->toArray())->paginate(25),
                200
            );
        } else {
            return response()->json(
                Action::where('user_id', $request->user('api')->id)->paginate(25),
                200
            );
        }
    }
}
