<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\UpdateRequest;
use App\Repositories\FillRepository;
use App\Repositories\UploadRepository;
use App\User;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, User $user)
    {
        UploadRepository::checkPhotoForUpload($request, $user);

        $user->load('user', 'photo');

        $user->update([
            'email' => FillRepository::fillMethod($request, 'email', $user->email),
            'name' => FillRepository::fillMethod($request, 'name', $user->name),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $user->is_public),
        ]);
        return response()->json($user, 200);
    }
}
