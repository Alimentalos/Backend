<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Asserts\UserAssert;
use Demency\Relationships\Lists\UserList;
use Demency\Relationships\Models\User;
use Demency\Relationships\Procedures\UserProcedure;

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
        ], only('email', 'name', 'is_public', 'country', 'region', 'city', 'city_name', 'region_name', 'country_name')));
    }
}
