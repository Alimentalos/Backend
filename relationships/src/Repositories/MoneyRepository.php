<?php


namespace Demency\Relationships\Repositories;


use App\Coin;
use Demency\Contracts\Monetizer;
use App\Operation;
use Exception;

class MoneyRepository
{
    public static function getMonetizerBalance(Monetizer $monetizer)
    {
        return $monetizer->coins()->where('used', false)->sum('amount');
    }

    /**
     * Inbound amount into receiver
     *
     * @param Monetizer $receiver
     * @param $amount
     * @param Monetizer|null $emitter
     * @return array
     * @throws Exception
     */
    public static function inbound(Monetizer $receiver, $amount, Monetizer $emitter = null)
    {
        $accepted = false;

        if (!is_null($emitter)) {
            $founds = static::getMonetizerBalance($emitter);
            if ($amount <= $founds) {
                $accepted = true;
                static::mergeFounds($emitter, $amount);
            }
        } else {
            $accepted = true;
        }

        if ($accepted) {
            $operation = static::createOperation($receiver, $amount, $emitter);

            $coin = static::createCoin($receiver, $amount, $operation, false);
            return [
                'coin' => $coin,
                'operation' => $operation,
            ];
        } else {
            throw new Exception("Emitter doesn't have founds");
        }
    }

    public static function mergeFounds(Monetizer $monetizer, $amount)
    {
        // Required amount
        $operation = static::createOperation($monetizer, $amount, $monetizer);

        $balance = static::getMonetizerBalance($monetizer);

        $monetizer->coins()->update([
            'used' => true,
            'used_operation_uuid' => $operation->uuid
        ]);
        // Used amount
        static::createCoin($monetizer, $amount, $operation, true);

        if ($amount < $balance) {
            // Reduced amount
            static::createCoin($monetizer, ($balance - $amount), $operation, false);
        }
    }

    private static function createCoin($monetizer, $amount, $operation, $used)
    {
        $coin = new Coin();
        $coin->monetizer_id = $monetizer->uuid;
        $coin->monetizer_type = get_class($monetizer);
        $coin->amount = $amount;
        $coin->used = $used;
        $coin->received_operation_uuid = $operation->uuid;
        if ($used) {
            $coin->used_operation_uuid = $operation->uuid;
        }
        $coin->save();
        return $coin;
    }

    private static function createOperation($receiver, $amount, $emitter = null)
    {
        $operation = new Operation();
        $operation->receiver_id = $receiver->uuid;
        $operation->receiver_type = get_class($receiver);
        if (!is_null($emitter)) {
            $operation->emitter_id = $emitter->uuid;
            $operation->emitter_type = get_class($emitter);
        }
        $operation->amount = $amount;
        $operation->save();
        return $operation;
    }
}
