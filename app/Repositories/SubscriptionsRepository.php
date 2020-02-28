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
     * Basic resource quota limits.
     *
     * @var array
     */
    public static $options = [
        'free' => [
            'devices' => [
                'create' => 3
            ],
            'groups' => [
                'create' => 2
            ],
            'photos' => [
                'create' => 100
            ],
            'comments' => [
                'create' => 1000
            ],
            'users' => [
                'create' => 3
            ],
            'pets' => [
                'create' => 10
            ],
            'geofences' => [
                'create' => 1
            ],
            'user_group' => [
                'join' => 3
            ]
        ],
        'tier-1' => [
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
        ],
        'tier-2' => [
            'devices' => [
                'create' => 10
            ],
            'groups' => [
                'create' => 5
            ],
            'photos' => [
                'create' => 1000
            ],
            'comments' => [
                'create' => 5000
            ],
            'users' => [
                'create' => 20
            ],
            'pets' => [
                'create' => 50
            ],
            'geofences' => [
                'create' => 20
            ],
            'user_group' => [
                'join' => 20
            ]
        ],
        'tier-3' => [
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
        ]
    ];

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
            return 'tier-1';
        }
    }

    /**
     * Find current user resource used quota.
     *
     * @param $resource
     * @param $user
     * @return mixed
     */
    public static function findResources($resource, $user)
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
        if ($user->is_child) {
            return false;
        }
        $tier = static::determineTier($user);
        $quantity = static::findResources($resource, $user);
        return ($quantity + 1) <= self::$options[$tier][$resource][$method];
    }
}
