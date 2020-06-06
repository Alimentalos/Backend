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
        upload()->check($user);

        // Marker
        if (rhas('marker')) {
            $marker_uuid = uuid();
            photos()->storePhoto($marker_uuid, uploaded('marker'));
            $user->update([
                'marker' => config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension())
            ]);
        }

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

        // Check if has marker
        if (rhas('marker')) {
            $marker_uuid = uuid();
            photos()->storePhoto($marker_uuid, uploaded('marker'));
            $properties['marker'] = config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension());
        }

        $fill = request()->only(array_merge(['name', 'email', 'is_public', 'locale'], User::getColors()));

        // Attributes
        $user = User::create(array_merge($properties, $fill));

        // Check if request has photo
        if (rhas('photo')) {
            upload()->check($user);
        }
        return $user;
    }
}
