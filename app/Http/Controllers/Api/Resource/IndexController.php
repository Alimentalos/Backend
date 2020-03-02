<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\IndexRequest;
use App\Repositories\HandleBindingRepository;
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
        $resource = HandleBindingRepository::bindResourceModelClass(HandleBindingRepository::detectResourceType());

        $models = $resource::resolveModels($request);

        return response()
            ->json($models, 200);
    }
}
