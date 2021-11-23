<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Repositories\ResourceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller {
    use RefreshDatabase;
    /**
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke($resource)
    {
        $model = ResourceRepository::retrieve($resource);
        $paginated = $model->getQuery()->with($model->getLazyRelationshipsAttribute())->paginate(20);
        return response()->json($paginated, 200);
    }
}
