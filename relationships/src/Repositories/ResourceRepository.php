<?php


namespace Demency\Relationships\Repositories;

use Demency\Relationships\Asserts\ResourceGroupAssert;
use Demency\Contracts\Resource;

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
     * Get current resource instance.
     *
     * @return Resource
     */
    public function current()
    {
        return finder()->findClass(finder()->currentResource());
    }
}
