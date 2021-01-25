<?php

namespace App\Repositories;

use Alimentalos\Relationships\Asserts\GroupAssert;
use Alimentalos\Relationships\Lists\GroupList;
use App\Models\Group;
use Alimentalos\Relationships\Procedures\GroupProcedure;

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
