<?php


namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Asserts\ResourceGroupAssert;

class ResourceRepository
{
    use ResourceGroupAssert;

    /**
     * User resource.
     */
    public const USER = 'Alimentalos\\Relationships\\Models\\User';

    /**
     * Device resource.
     */
    public const DEVICE = 'Alimentalos\\Relationships\\Models\\Device';

    /**
     * Pet resource.
     */
    public const PET = 'Alimentalos\\Relationships\\Models\\Pet';

    /**
     * Group resource.
     */
    public const GROUP = 'Alimentalos\\Relationships\\Models\\Group';

    /**
     * Photo resource.
     */
    public const PHOTO = 'Alimentalos\\Relationships\\Models\\Photo';

    /**
     * Comment resource.
     */
    public const COMMENT = 'Alimentalos\\Relationships\\Models\\Comment';

    /**
     * Available resources.
     *
     * @return array
     */
    public function values()
    {
        return [
            self::USER,
            self::DEVICE,
            self::PET,
            self::GROUP,
            self::PHOTO,
            self::COMMENT
        ];
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
