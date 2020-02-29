<?php

namespace App\Repositories;

use App\Group;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GroupsRepository
{
    public static function updateGroupViaRequest(Request $request, Group $group)
    {
        UploadRepository::checkPhotoForUpload($request, $group);
        $group->update([
            'name' => FillRepository::fillMethod($request, 'name', $group->name),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $group->is_public)
        ]);
        $group->load('photo', 'user');
        return $group;
    }

    public static function createGroupViaRequest(Request $request, Photo $photo)
    {
        $group = Group::create([
            'name' => $request->input('name'),
            'user_id' => $request->user('api')->id,
            'photo_id' => $photo->id,
            'photo_url' => config('storage.path') . $photo->photo_url,
        ]);
        $request->user('api')
            ->groups()
            ->attach(
                $group->id,
                [
                    'is_admin' => true,
                    'status' => Group::ACCEPTED_STATUS,
                    'sender_id' => $request->user('api')->id,
                ]
            );
        $group->photos()->attach($photo->id);
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
        return $model->user_id === $user->id || $user->groups()
                ->whereIn(
                    'group_id',
                    $model->groups->pluck('id')->toArray()
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
        return $user->id === $group->user_id || $user->groups()->whereIn('status', [
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
        return $model->groups()->where('group_id', $group->id)
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
        return $model->groups()->where('group_id', $group->id)
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
        return in_array($groupId, $user->groups->pluck('id')->toArray());
    }
}
