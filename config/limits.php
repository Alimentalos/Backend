<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Free limits
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default free limits quota,
    |
    */

    'free' => [
        'devices' => [
            'create' => 5
        ],
        'groups' => [
            'create' => 3
        ],
        'places' => [
            'create' => 10
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

    /*
    |--------------------------------------------------------------------------
    | Premium limits
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default premium limits quota,
    |
    */

    'premium' => [
        'devices' => [
            'create' => 5
        ],
        'groups' => [
            'create' => 3
        ],
        'places' => [
            'create' => 50
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

];
