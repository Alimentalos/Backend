<?php


namespace App\Repositories;

use App\Asserts\ResourceGroupAssert;
use App\Contracts\Resource;

class ResourceRepository
{
    use ResourceGroupAssert;

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
    public function values()
    {
        return [ self::USER, self::DEVICE, self::PET ];
    }

    /**
     * @return Resource
     */
    public function currentResource()
    {
        return finder()->findClass(finder()->currentResource());
    }
}
