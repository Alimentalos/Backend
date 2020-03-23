<?php

namespace Alimentalos\Relationships\Observers;

use App\Passport\Client;

class ClientObserver
{
    /**
     * Handle the client "creating" event.
     *
     * @param  \App\Passport\Client  $client
     * @return void
     * @codeCoverageIgnore
     */
    public function creating(Client $client)
    {
        $client->id = uuid();
    }
}
