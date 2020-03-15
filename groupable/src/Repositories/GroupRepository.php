<?php

namespace Demency\Groupable\Repositories;

use Demency\Groupable\Models\Group;
use Demency\Groupable\Lists\GroupList;
use Demency\Groupable\Procedures\GroupProcedure;
use Demency\Groupable\Asserts\GroupAssert;

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
