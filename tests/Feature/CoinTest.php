<?php


namespace Tests\Feature;


use Demency\Relationships\Models\Coin;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Operation;
use Demency\Relationships\Repositories\MoneyRepository;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinTest extends TestCase
{
    use RefreshDatabase;

    public function testCoinCreation()
    {
        $coin = factory(Coin::class)->create();
        $received_operation = factory(Operation::class)->create();
        $used_operation = factory(Operation::class)->create();
        $coin->received_operation()->associate($received_operation);
        $coin->used_operation()->associate($used_operation);
        $this->assertEquals($coin->used_operation->uuid, $used_operation->uuid);
        $this->assertEquals($coin->received_operation->uuid, $received_operation->uuid);
    }

    public function testUserCanHaveCoins()
    {
        $user = factory(User::class)->create();
        $coin = $user->coins()->create([
            'received_operation_uuid' => factory(Operation::class)->create()->uuid,
            'amount' => 100,
            'used' => false,
        ]);
        $monetizer = $coin->monetizer;
        $this->assertEquals($user->uuid, $monetizer->uuid);
    }

    public function testTransferAllCoinsOperation()
    {
        $user = factory(User::class)->create();
        MoneyRepository::inbound($user, 100);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals($amount, 100);
        $group = factory(Group::class)->create();
        $prof = MoneyRepository::inbound($group, 100, $user);
        $operation = $prof['operation'];
        $this->assertEquals($operation->receiver->uuid, $group->uuid);
        $this->assertEquals($operation->emitter->uuid, $user->uuid);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals(0, $amount);
    }

    public function testTransferPartOfCoinsOperation()
    {
        $user = factory(User::class)->create();
        MoneyRepository::inbound($user, 300);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals($amount, 300);
        $group = factory(Group::class)->create();
        $prof = MoneyRepository::inbound($group, 100, $user);
        $operation = $prof['operation'];
        $this->assertEquals($operation->receiver->uuid, $group->uuid);
        $this->assertEquals($operation->emitter->uuid, $user->uuid);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals(200, $amount);
    }

    public function testGroupTransferPartOfCoinsToUser()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        MoneyRepository::inbound($group, 300);
        $amount = MoneyRepository::getMonetizerBalance($group);
        $this->assertEquals($amount, 300);
        $prof = MoneyRepository::inbound($user, 100, $group);
        $operation = $prof['operation'];
        $this->assertEquals($operation->receiver->uuid, $user->uuid);
        $this->assertEquals($operation->emitter->uuid, $group->uuid);
        $amount = MoneyRepository::getMonetizerBalance($group);
        $this->assertEquals(200, $amount);
    }

    public function testUserDoesntHaveFounds()
    {
        try {

            $user = factory(User::class)->create();
            $group = factory(Group::class)->create();
            $prof = MoneyRepository::inbound($user, 100, $group);
        } catch (\Exception $exception) {
            // Yeah sure, this user doesn't have funds.
            $this->assertTrue(true);
        }
    }
}

