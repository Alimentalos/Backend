<?php

namespace App\Repositories;

use App\Group;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GroupsRepository
{
    public function getUserGroups()
    {
        return Group::with('user', 'photo')
            ->where('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true)
            ->orWhereIn('uuid', authenticated()->groups->map(function($group) { return $group->uuid; }))
            ->latest()
            ->paginate(25);
    }

    /**
     * Get administrator groups.
     *
     * @return LengthAwarePaginator
     */
    public function getAdministratorGroups()
    {
        return Group::with('user', 'photo')
            ->latest()
            ->paginate(25);
    }

    /**
     * Update group via request.
     *
     * @param Request $request
     * @param Group $group
     * @return Group
     */
    public static function updateGroupViaRequest(Request $request, Group $group)
    {
        UploadRepository::checkPhotoForUpload($request, $group);
        $group->update(parameters()->fillPropertiesUsingResource(['name', 'is_public'], $group));
        $group->load('photo', 'user');
        return $group;
    }

    /**
     * Create group via request.
     *
     * @param Request $request
     * @return Group
     */
    public static function createGroupViaRequest(Request $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $group = Group::create([
            'name' => $request->input('name'),
            'user_uuid' => $request->user('api')->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . $photo->photo_url,
        ]);
        $request->user('api')
            ->groups()
            ->attach(
                $group->uuid,
                [
                    'is_admin' => true,
                    'status' => Group::ACCEPTED_STATUS,
                    'sender_uuid' => $request->user('api')->uuid,
                ]
            );
        $group->photos()->attach($photo->uuid);
        $group->load('photo', 'user');
        return $group;
    }

    /**
     * Check if user has model.
     *
     * @param User $user
     * @param object|Model $model
     * @return boolean
     */
    public static function userHasModel(User $user, Model $model)
    {
        return $model->user_uuid === $user->uuid || $user->groups()
                ->whereIn(
                    'uuid',
                    $model->groups->pluck('uuid')->toArray()
                )->exists();
    }

    /**
     * Check if user is group admin.
     *
     * @param object|User $user
     * @param object|Group $group
     * @return bool
     */
    public static function userIsGroupAdmin(User $user, Group $group)
    {
        return $user->uuid === $group->user_uuid || $user->groups()->whereIn('status', [
            Group::ACCEPTED_STATUS, Group::ATTACHED_STATUS
        ])->where('is_admin', true)->exists();
    }

    /**
     * Check if model is group model.
     *
     * @param object|Model $model
     * @param object|Group $group
     * @return bool
     */
    public static function modelIsGroupModel(Model $model, Group $group)
    {
        return $model->groups()->where('group_uuid', $group->uuid)
            ->whereIn('status', [
                Group::ACCEPTED_STATUS, Group::ATTACHED_STATUS
            ])->exists();
    }

    /**
     * Check if model is blocked.
     *
     * @param object|Model $model
     * @param object|Group $group
     * @return bool
     */
    public static function modelIsBlocked(Model $model, Group $group)
    {
        return $model->groups()->where('group_uuid', $group->uuid)
            ->whereIn('status', [
                Group::BLOCKED_STATUS
            ])->exists();
    }

    /**
     * User has a group id.
     *
     * @param User $user
     * @param $groupId
     * @return bool
     */
    public static function userHasGroup(User $user, $groupId)
    {
        return in_array($groupId, $user->groups->pluck('uuid')->toArray());
    }
}
