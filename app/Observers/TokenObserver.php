<?php

namespace App\Observers;

use App\Passport\Token;

class TokenObserver
{
    /**
     * Handle the client "creating" event.
     *
     * @param Token $token
     * @return void
     * @codeCoverageIgnore
     */
    public function creating(Token $token)
    {
        $token->id = uuid();
    }
}
