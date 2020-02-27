<?php

namespace App\Repositories;

use Ramsey\Uuid\Uuid;

class UniqueNameRepository
{
    public static function createIdentifier()
    {
        return (string) Uuid::uuid4();
    }
}
