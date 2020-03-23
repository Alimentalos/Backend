<?php


namespace Demency\Tools;

use Exception;
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
            try {
                return (string) Uuid::uuid4();
            } catch (Exception $exception) {
                // Why uuid will be fail a twice?
            }
        }
    }
    // @codeCoverageIgnoreEnd
}
