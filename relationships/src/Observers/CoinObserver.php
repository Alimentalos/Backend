<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Coin;

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
