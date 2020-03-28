<?php


namespace Alimentalos\Relationships\Procedures;

use Alimentalos\Relationships\Models\Group;

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
            'color' => fill('color', null),
            'background_color' => fill('background_color', null),
            'border_color' => fill('border_color', null),
            'fill_color' => fill('fill_color', null),
            'text_color' => fill('text_color', null),
            'administrator_color' => fill('administrator_color', null),
            'user_color' => fill('user_color', null),
            'owner_color' => fill('owner_color', null)
        ]);
        authenticated()->groups()->attach($group->uuid, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS,
            'sender_uuid' => authenticated()->uuid,
        ]);
        $group->photos()->attach($photo->uuid);
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
        $group->update(parameters()->fill([
            'name',
            'is_public',
            'color',
            'border_color',
            'fill_color',
            'text_color',
            'background_color',
            'administrator_color',
            'user_color',
            'owner_color',
        ], $group));
        return $group;
    }
}
