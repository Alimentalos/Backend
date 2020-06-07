<?php

namespace Alimentalos\Relationships\Procedures;

use Alimentalos\Relationships\Models\User;

trait UserProcedure
{
    /**
     * Current user properties.
     *
     * @var string[]
     */
    protected $userProperties = [
        'email',
        'name',
        'is_public',
        'country',
        'region',
        'city',
        'city_name',
        'region_name',
        'country_name',
        'locale'
    ];

    /**
     * Update user.
     *
     * @param User $user
     * @return User
     */
    public function updateInstance(User $user)
    {
        // Check photo uploaded
        upload()->checkPhoto($user);

        // Marker
        upload()->checkMarker($user);

        // Attributes
        fillAndUpdate($user, $this->userProperties, User::getColors());

        return $user;
    }

    /**
     * Create user.
     *
     * @return User
     */
    public function createInstance()
    {
        // Default properties
        $properties = [
            'user_uuid' => authenticated()->uuid,
            'password' => bcrypt(input('password')),
        ];

        $fill = request()->only(
            array_merge($this->userProperties, User::getColors())
        );

        // Attributes
        $user = User::create(array_merge($properties, $fill));

        // Photo
        upload()->checkPhoto($user);

        // Marker
        upload()->checkMarker($user);

        return $user;
    }
}
