<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\UpdateRequest;
use App\Repositories\FillRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Group $group)
    {
        // TODO - Remove unnecessary complexity
        if ($request->has('photo')) {
            $photo = PhotoRepository::createPhoto(
                $request->user('api'),
                $request->file('photo'),
                null,
                null,
                FillRepository::fillMethod($request, 'is_public', $group->is_public),
                $request->input('coordinates')
            );

            $group->update([
                'name' => FillRepository::fillMethod($request, 'name', $group->name),
                'photo_id' => $photo->id,
                'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
                'is_public' => FillRepository::fillMethod($request, 'is_public', $group->is_public)
            ]);
            $group->photos()->attach($photo->id);
        } else {
            $group->update([
                'name' => FillRepository::fillMethod($request, 'name', $group->name),
                'is_public' => FillRepository::fillMethod($request, 'is_public', $group->is_public)
            ]);
        }

        $group->load('photo', 'user');

        return response()->json($group, 200);
    }
}
