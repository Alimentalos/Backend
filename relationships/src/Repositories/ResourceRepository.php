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
    public const USER = 'Demency\\Relationships\\Models\\User';

    /**
     * Device resource.
     */
    public const DEVICE = 'Demency\\Relationships\\Models\\Device';

    /**
     * Pet resource.
     */
    public const PET = 'Demency\\Relationships\\Models\\Pet';

    /**
     * Group resource.
     */
    public const GROUP = 'Demency\\Relationships\\Models\\Group';

    /**
     * Photo resource.
     */
    public const PHOTO = 'Demency\\Relationships\\Models\\Photo';

    /**
     * Comment resource.
     */
    public const COMMENT = 'Demency\\Relationships\\Models\\Comment';

    /**
     * Available resources.
     *
     * @return array
     */
    public function values()
    {
        return [ self::USER, self::DEVICE, self::PET, self::GROUP, self::PHOTO, self::COMMENT ];
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
