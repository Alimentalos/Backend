<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersSaveMethodOnGroupClass()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $group->users()->save($user);

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\User',
            'groupable_id' => $user->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }

    public function testGroupsSaveMethodOnUserClass()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $user->groups()->save($group);

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\User',
            'groupable_id' => $user->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }
}
