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

    public static function determineTier(User $user)
    {
        if ($user->free) {
            return 'free';
        } else {
            return 'tier-1';
        }
    }

    public static function can($method, $resource, User $user)
    {
        if ($user->is_child) {
            return false;
        }
        $tier = static::determineTier($user);
        $quantity = 0;
        switch ($resource) {
            case 'devices':
                $quantity = Device::where('user_id', $user->id)->count();
                break;
            case 'groups':
                $quantity = Group::where('user_id', $user->id)->count();
                break;
            case 'users':
                $quantity = User::where('user_id', $user->id)->count();
                break;
            case 'photos':
                $quantity = Photo::where('user_id', $user->id)->count();
                break;
            case 'comments':
                $quantity = Comment::where('user_id', $user->id)->count();
                break;
            case 'pets':
                $quantity = Pet::where('user_id', $user->id)->count();
                break;
        }
        return ($quantity + 1) <= self::$options[$tier][$resource][$method];
    }
}
