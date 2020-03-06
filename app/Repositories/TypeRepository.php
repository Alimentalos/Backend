<?php


namespace App\Repositories;


class TypeRepository
{
    /**
     * Lost type.
     */
    public const LOST = 0;

    /**
     * Dead type.
     */
    public const DEAD = -1;

    /**
     * Found type.
     */
    public const FOUND = 1;

    /**
     * Available alert types.
     *
     * @return array
     */
    public static function values()
    {
        return [
            self::FOUND,
            self::DEAD,
            self::LOST,
        ];
    }
}
