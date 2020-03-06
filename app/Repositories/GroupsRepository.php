<?php

namespace App\Repositories;

use App\Asserts\GroupAssert;
use App\Group;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GroupsRepository
{
    use GroupAssert;

    public function getUserGroups()
    {
        return Group::with('user', 'photo')
            ->where('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true)
            ->orWhereIn('uuid', authenticated()->groups->pluck('uuid')->toArray())
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
     * @param Group $group
     * @return Group
     */
    public static function updateGroupViaRequest(Group $group)
    {
        upload()->check($group);
        $group->update(parameters()->fill(['name', 'is_public'], $group));
        $group->load('photo', 'user');
        return $group;
    }

    /**
     * Create group via request.
     *
     * @return Group
     */
    public static function createGroupViaRequest()
    {
        $photo = photos()->createViaRequest();
        $group = Group::create([
            'name' => input('name'),
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . $photo->photo_url,
        ]);
        authenticated()->groups()
            ->attach(
                $group->uuid,
                [
                    'is_admin' => true,
                    'status' => Group::ACCEPTED_STATUS,
                    'sender_uuid' => authenticated()->uuid,
                ]
            );
        $group->photos()->attach($photo->uuid);
        $group->load('photo', 'user');
        return $group;
    }
}
