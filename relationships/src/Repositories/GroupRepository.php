<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Models\Group;
use Demency\Relationships\Lists\GroupList;
use Demency\Relationships\Procedures\GroupProcedure;
use Demency\Relationships\Asserts\GroupAssert;

class GroupRepository
{
    use GroupAssert;
    use GroupList;
    use GroupProcedure;

    /**
     * Create group.
     *
     * @return Group
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update group.
     *
     * @param Group $group
     * @return Group
     */
    public function update(Group $group)
    {
        return $this->updateInstance($group);
    }
}
