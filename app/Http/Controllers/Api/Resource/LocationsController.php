<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizedRequest;
use App\Repositories\ResourceLocationsRepository;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorizedRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthorizedRequest $request)
    {
        return response()->json(ResourceLocationsRepository::createViaRequest($request),201);
    }
}
