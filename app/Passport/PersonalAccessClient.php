<?php

namespace App\Passport;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class PersonalAccessClient extends PassportPersonalAccessClient
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_personal_access_clients';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the authentication codes for the client.
     *
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Passport::clientModel(), 'client_uuid', 'id');
    }
}
