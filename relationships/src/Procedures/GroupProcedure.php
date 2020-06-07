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
        $properties = [
            'name' => input('name'),
            'user_uuid' => authenticated()->uuid,
        ];

        $fill = [];
        foreach (Group::getColors() as $color) {
            $fill[$color] = fill($color, null);
        }

        $group = Group::create(array_merge($properties, $fill));

        authenticated()->groups()->attach($group->uuid, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS,
            'sender_uuid' => authenticated()->uuid,
        ]);

        upload()->checkPhoto($group);

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
        upload()->checkPhoto($group);
        fillAndUpdate($group, ['name', 'is_public'], Group::getColors());
        return $group;
    }
}
