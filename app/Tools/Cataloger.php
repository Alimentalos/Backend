<?php


namespace App\Tools;


class Cataloger
{
    /**
     * Created status-
     */
    public const CREATED = 1;

    /**
     * Published status-
     */
    public const PUBLISHED = 2;

    /**
     * Founded status-
     */
    public const FOUNDED = 3;

    /**
     * Resolved status-
     */
    public const RESOLVED = 4;

    /**
     * Closed status.
     */
    public const CLOSED = 5;

    /**
     * Get statuses values.
     *
     * @return array
     */
    public function types()
    {
        return [
            self::CREATED,
            self::PUBLISHED,
            self::FOUNDED,
            self::RESOLVED,
            self::CLOSED
        ];
    }
}
