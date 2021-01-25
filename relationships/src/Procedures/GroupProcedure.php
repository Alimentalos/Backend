<?php


namespace Alimentalos\Relationships\Procedures;

use App\Models\Group;

trait GroupProcedure
{
    protected $groupProperties = [
        'name',
        'is_public'
    ];

    /**
     * Create group instance.
     */
    public function createInstance()
    {
        $properties = request()->only(
            array_merge($this->groupProperties, Group::getColors())
        );
        $group = Group::create($properties);
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
        fillAndUpdate($group, $this->groupProperties, Group::getColors());
        return $group;
    }
}
