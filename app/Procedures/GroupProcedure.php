<?php


namespace App\Procedures;


use App\Group;

trait GroupProcedure
{
    /**
     * Create group instance.
     */
    public function createInstance()
    {
        $photo = photos()->create();
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

    /**
     * Update group instance.
     *
     * @param Group $group
     * @return Group
     */
    public function updateInstance(Group $group)
    {
        upload()->check($group);
        $group->update(parameters()->fill(['name', 'is_public'], $group));
        $group->load('photo', 'user');
        return $group;
    }
}
