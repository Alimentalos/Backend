<?php


namespace App\Tools;


use Ramsey\Uuid\Uuid;

class Identifier
{
    /**
     * Create unique identifier.
     *
     * @return string
     */
    public static function create()
    {
        try {
            return (string) Uuid::uuid4();
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            // TODO - Uuid exception unhandled
        }
    }
    // @codeCoverageIgnoreEnd
}
