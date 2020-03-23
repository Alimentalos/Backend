<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Lists\GroupList;
use Alimentalos\Relationships\Procedures\GroupProcedure;
use Alimentalos\Relationships\Asserts\GroupAssert;

class GroupsRepository
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
