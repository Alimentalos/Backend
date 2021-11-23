<?php


namespace App\Repositories;

use App\Contracts\Resource;
use Alimentalos\Relationships\Asserts\ResourceGroupAssert;
use Illuminate\Support\Str;

class ResourceRepository
{
    use ResourceGroupAssert;

    /**
     * User resource.
     */
    public const USER = 'App\\Models\\User';

    /**
     * Device resource.
     */
    public const DEVICE = 'App\\Models\\Device';

    /**
     * Pet resource.
     */
    public const PET = 'App\\Models\\Pet';

    /**
     * Group resource.
     */
    public const GROUP = 'App\\Models\\Group';

    /**
     * Photo resource.
     */
    public const PHOTO = 'App\\Models\\Photo';

    /**
     * Comment resource.
     */
    public const COMMENT = 'App\\Models\\Comment';

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
