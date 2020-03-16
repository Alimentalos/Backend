<?php

namespace App\Repositories;

use Demency\Relationships\Models\User;

class AdminRepository
{
    /**
     * List of administrators
     *
     * @var array
     */
    protected static $list = [
        'iantorres@outlook.com',
        'd.ignacio292@gmail.com'
    ];

    /**
     * Check if user is admin
     *
     * @param User $user
     * @return boolean
     */
    public function isAdmin(User $user)
    {
        return in_array($user->email, static::$list);
    }
}
