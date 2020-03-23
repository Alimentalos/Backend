<?php


namespace Alimentalos\Tools;

use Exception;
use Ramsey\Uuid\Uuid;

class Identifier
{
    /**
     * Create unique identifier.
     *
     * @return string
     * @throws Exception
     */
    public static function create()
    {
        return (string) Uuid::uuid4();
    }
}
