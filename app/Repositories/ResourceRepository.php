<?php


namespace App\Repositories;


class ResourceRepository
{
    /**
     * User resource.
     */
    public const USER = 'App\\User';

    /**
     * Device resource.
     */
    public const DEVICE = 'App\\Device';

    /**
     * Pet resource.
     */
    public const PET = 'App\\Pet';

    /**
     * Available resources.
     *
     * @return array
     */
    public static function availableResource()
    {
        return [ self::USER, self::DEVICE, self::PET ];
    }
}
