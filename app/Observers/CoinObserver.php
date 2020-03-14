<?php

namespace App\Observers;

use App\Coin;

class CoinObserver
{
    /**
     * Handle the coin "creating" event.
     *
     * @param Coin $coin
     * @return void
     */
    public function creating(Coin $coin)
    {
        $coin->uuid = uuid();
    }
}
