<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Group $group
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Group $group)
    {
        $group->delete();
        // TODO - Refactor using constant
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
