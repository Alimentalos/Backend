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
     */
    public function __invoke(DestroyRequest $request, Comment $comment)
    {
        try {
            $comment->delete();

            return response()->json(
                ['message' => 'Deleted successfully.'],
                200
            );
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return response()->json(
                ['message' => 'Resource cannot be deleted.'],
                500
            );
        }
        // @codeCoverageIgnoreEnd
    }
}
