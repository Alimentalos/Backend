<?php

namespace App\Repositories;

use Exception;
use Ramsey\Uuid\Uuid;

class UniqueNameRepository
{
    /**
     * Create unique identifier.
     *
     * @return string
     * @throws Exception
     */
    public static function createIdentifier()
    {
        return (string) Uuid::uuid4();
    }
}
