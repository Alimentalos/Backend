<?php

namespace Tests\Feature;

use App\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
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
            'groupable_id' => $user->id,
            'group_id' => $group->id,
        ]);
    }

    public function testGroupsSaveMethodOnUserClass()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $user->groups()->save($group);

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\User',
            'groupable_id' => $user->id,
            'group_id' => $group->id,
        ]);
    }
}
