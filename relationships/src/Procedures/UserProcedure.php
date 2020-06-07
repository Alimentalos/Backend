<?php

namespace Alimentalos\Relationships\Procedures;

use Alimentalos\Relationships\Models\User;

trait UserProcedure
{
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
        $user->update(
            parameters()->fill(
                array_merge(
                    [
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
                    ],
                    User::getColors()
                ), $user
            )
        );

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

        $fill = request()->only(array_merge(['name', 'email', 'is_public', 'locale'], User::getColors()));

        // Attributes
        $user = User::create(array_merge($properties, $fill));

        // Photo
        upload()->checkPhoto($user);

        // Marker
        upload()->checkMarker($user);

        return $user;
    }
}
