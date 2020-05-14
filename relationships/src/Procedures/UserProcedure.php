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
        // Check photo uploaded
        $photo = photos()->create();

        // Marker
        $marker_uuid = uuid();
        photos()->storePhoto($marker_uuid, uploaded('marker'));

        $properties = [
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'marker' => config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension()),
            'photo_url' => config('storage.path') . 'photos/' . $photo->photo_url,
            'password' => bcrypt(input('password')),
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ];

        $fill = request()->only(array_merge(['name', 'email', 'is_public', 'locale'], User::getColors()));

        // Attributes
        $user = User::create(array_merge($properties, $fill));

        $user->photos()->attach($photo->uuid);
        return $user;
    }
}
