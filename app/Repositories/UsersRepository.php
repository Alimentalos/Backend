<?php

namespace App\Repositories;

use Alimentalos\Relationships\Asserts\UserAssert;
use Alimentalos\Relationships\Lists\UserList;
use App\Models\User;
use Alimentalos\Relationships\Procedures\UserProcedure;

class UsersRepository
{
    use UserAssert;
    use UserList;
    use UserProcedure;

    /**
     * Create geofence.
     *
     * @return User
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update geofence.
     *
     * @param User $user
     * @return User
     */
    public function update(User $user)
    {
        return $this->updateInstance($user);
    }

    /**
     * Register user.
     *
     * @return mixed
     */
    public function register()
    {
        return User::create(array_merge([
            'password' => bcrypt(input('password')),
        ], only('email',
            'name',
            'locale',
            'is_public',
            'country',
            'region',
            'city',
            'city_name',
            'region_name',
            'country_name'
        )));
    }
}
