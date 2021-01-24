<?php


namespace Tests\Feature;


use App\Models\Coin;
use App\Models\Group;
use App\Models\Operation;
use Alimentalos\Relationships\Repositories\MoneyRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinTest extends TestCase
{
    use RefreshDatabase;

    public function testCoinCreation()
    {
        $coin = Coin::factory()->create();
        $received_operation = Operation::factory()->create();
        $used_operation = Operation::factory()->create();
        $coin->received_operation()->associate($received_operation);
        $coin->used_operation()->associate($used_operation);
        $this->assertEquals($coin->used_operation->uuid, $used_operation->uuid);
        $this->assertEquals($coin->received_operation->uuid, $received_operation->uuid);
    }

    public function testUserCanHaveCoins()
    {
        $user = User::factory()->create();
        $coin = $user->coins()->create([
            'received_operation_uuid' => Operation::factory()->create()->uuid,
            'amount' => 100,
            'used' => false,
        ]);
        $monetizer = $coin->monetizer;
        $this->assertEquals($user->uuid, $monetizer->uuid);
    }

    public function testTransferAllCoinsOperation()
    {
        $user = User::factory()->create();
        MoneyRepository::inbound($user, 100);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals($amount, 100);
        $group = Group::factory()->create();
        $prof = MoneyRepository::inbound($group, 100, $user);
        $operation = $prof['operation'];
        $this->assertEquals($operation->receiver->uuid, $group->uuid);
        $this->assertEquals($operation->emitter->uuid, $user->uuid);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals(0, $amount);
    }

    public function testTransferPartOfCoinsOperation()
    {
        $user = User::factory()->create();
        MoneyRepository::inbound($user, 300);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals($amount, 300);
        $group = Group::factory()->create();
        $prof = MoneyRepository::inbound($group, 100, $user);
        $operation = $prof['operation'];
        $this->assertEquals($operation->receiver->uuid, $group->uuid);
        $this->assertEquals($operation->emitter->uuid, $user->uuid);
        $amount = MoneyRepository::getMonetizerBalance($user);
        $this->assertEquals(200, $amount);
    }

    public function testGroupTransferPartOfCoinsToUser()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
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

            $user = User::factory()->create();
            $group = Group::factory()->create();
            $prof = MoneyRepository::inbound($user, 100, $group);
        } catch (\Exception $exception) {
            // Yeah sure, this user doesn't have funds.
            $this->assertTrue(true);
        }
    }
}

