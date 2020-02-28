<?php

namespace App\Repositories;

use App\Comment;
use App\Device;
use App\Group;
use App\Pet;
use App\Photo;
use App\User;

class SubscriptionsRepository
{
    /**
     * Determine user tier.
     *
     * @param User $user
     * @return string
     */
    public static function determineTier(User $user)
    {
        if ($user->free) {
            return 'free';
        } else {
            return 'premium';
        }
    }

    /**
     * Find current user resource used quota.
     *
     * @param $resource
     * @param $user
     * @return mixed
     */
    public static function getUserResourcesQuota($resource, $user)
    {
        switch ($resource) {
            case 'devices':
                return Device::where('user_id', $user->id)->count();
                break;
            case 'groups':
                return Group::where('user_id', $user->id)->count();
                break;
            case 'users':
                return User::where('user_id', $user->id)->count();
                break;
            case 'photos':
                return Photo::where('user_id', $user->id)->count();
                break;
            case 'comments':
                return Comment::where('user_id', $user->id)->count();
                break;
            case 'pets':
                return Pet::where('user_id', $user->id)->count();
                break;
        }
    }

    /**
     * Check if user can apply method on resources.
     *
     * @param $method
     * @param $resource
     * @param User $user
     * @return bool
     */
    public static function can($method, $resource, User $user)
    {
        $tier = static::determineTier($user);
        $quantity = static::getUserResourcesQuota($resource, $user);
        return ($quantity + 1) <= self::getOptions($tier, $resource, $method);
    }

    /**
     * Get premium quota limits.
     *
     * @param $resource
     * @param $method
     * @return mixed
     */
    public static function getPremiumLimits($resource, $method)
    {
        return static::calcLimits([
            'devices' => [
                'create' => 50
            ],
            'groups' => [
                'create' => 5
            ],
            'photos' => [
                'create' => 2000
            ],
            'comments' => [
                'create' => 10000
            ],
            'users' => [
                'create' => 20
            ],
            'pets' => [
                'create' => 100
            ],
            'geofences' => [
                'create' => 100
            ],
            'user_group' => [
                'join' => 20
            ]
        ], $resource, $method);
    }

    /**
     * Get free quota limits.
     *
     * @param $resource
     * @param $method
     * @return mixed
     */
    public static function getFreeLimits($resource, $method)
    {
        return static::calcLimits([
            'devices' => [
                'create' => 5
            ],
            'groups' => [
                'create' => 3
            ],
            'photos' => [
                'create' => 500
            ],
            'comments' => [
                'create' => 2000
            ],
            'users' => [
                'create' => 10
            ],
            'pets' => [
                'create' => 25
            ],
            'geofences' => [
                'create' => 10
            ],
            'user_group' => [
                'join' => 10
            ]
        ], $resource, $method);
    }

    /**
     * Calculate specific resource tier limits.
     *
     * @param $limits
     * @param $resource
     * @param $method
     * @return mixed
     */
    public static function calcLimits($limits, $resource, $method)
    {
        return $limits[$resource][$method];
    }

    /**
     * Get current user tier limits options.
     *
     * @param $tier
     * @param $resource
     * @param $method
     * @return mixed
     */
    public static function getOptions($tier, $resource, $method)
    {
        if ($tier === 'free') {
            return static::getFreeLimits($resource, $method);
        }
        return static::getPremiumLimits($resource, $method);
    }
}
