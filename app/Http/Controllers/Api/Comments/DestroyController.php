<?php

namespace App\Http\Controllers\Api\Comments;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comments\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Comment $comment
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Comment $comment)
    {
        $comment->delete();

        // TODO - Refactor using constant
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
