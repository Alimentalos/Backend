<?php

namespace App\Observers;

use App\Passport\Client;

class ClientObserver
{
    /**
     * Handle the client "creating" event.
     *
     * @param Client $client
     * @return void
     * @codeCoverageIgnore
     */
    public function creating(Client $client)
    {
        $client->id = uuid();
    }
}
