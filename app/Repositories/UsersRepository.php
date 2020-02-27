<?php

namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersRepository
{
    /**
     * Check if userA is same of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public static function sameUser(User $userA, User $userB)
    {
        return $userA->id === $userB->id;
    }

    /**
     * Check if userA has same owner of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public static function sameOwner(User $userA, User $userB)
    {
        return $userA->user_id === $userB->user_id;
    }

    /**
     * Check if userA is owner of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public static function isOwner(User $userA, User $userB)
    {
        return $userA->id === $userB->user_id;
    }

    /**
     * Check if userA is worker of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public static function isWorker(User $userA, User $userB)
    {
        return $userA->user_id === $userB->id;
    }

    /**
     * Check if device is property of user
     *
     * @param object|Model $model
     * @param object|User $user
     * @return bool
     */
    public static function isProperty(Model $model, User $user)
    {
        return $model->user_id === $user->id;
    }
}
