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
        upload()->check($user);
        $user->update(parameters()->fill(['email', 'name', 'is_public', 'country', 'region', 'city', 'city_name', 'region_name', 'country_name'], $user));
        return $user;
    }

    /**
     * Create user.
     *
     * @return User
     */
    public function createInstance()
    {
        $photo = photos()->create();
        $user = User::create(array_merge([
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'password' => bcrypt(input('password')),
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'email', 'is_public')));
        $user->photos()->attach($photo->uuid);
        return $user;
    }
}
