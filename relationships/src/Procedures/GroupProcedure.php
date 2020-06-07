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

        $properties = [
            'name' => input('name'),
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . 'photos/' . $photo->photo_url,
        ];

        $fill = array_map(
            fn($prop) => fill($prop, null),
            Group::getColors()
        );

        $group = Group::create(array_merge($properties, $fill));

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
        upload()->checkPhoto($group);
        $group->update(
            parameters()->fill(
                array_merge(
                    [
                        'name',
                        'is_public',
                    ],
                    Group::getColors()
                ),
                $group
            )
        );
        return $group;
    }
}
