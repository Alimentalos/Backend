<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Listable
    |--------------------------------------------------------------------------
    |
    */
	'listable' => [
		'places' => \App\Models\Place::class,
		'users' => \App\Models\User::class,
		'groups' => \App\Models\Group::class,
		'geofences' => \App\Models\Geofence::class,
		'pets' => \App\Models\Pet::class,
		'devices' => \App\Models\Device::class,
		'photos' => \App\Models\Photo::class,
		'actions' => \App\Models\Action::class,
		'alerts' => \App\Models\Alert::class
	],
	/*
    |--------------------------------------------------------------------------
    | Storable
    |--------------------------------------------------------------------------
    |
    */
	'storable' => [
		'places',
		'users',
		'pets',
		'groups',
		'geofences',
		'devices',
		'alerts'
	],
	/*
    |--------------------------------------------------------------------------
    | Viewable
    |--------------------------------------------------------------------------
    |
    */
	'viewable' => [
		'places' => \App\Models\Place::class,
		'groups' => \App\Models\Group::class,
		'locations' => \App\Models\Location::class,
		'actions' => \App\Models\Action::class,
		'geofences' => \App\Models\Geofence::class,
		'pets' => \App\Models\Pet::class,
		'devices' => \App\Models\Device::class,
		'users' => \App\Models\User::class,
		'photos' => \App\Models\Photo::class,
		'comments' => \App\Models\Comment::class,
		'alerts' => \App\Models\Alert::class
	],
	/*
    |--------------------------------------------------------------------------
    | Modifiable
    |--------------------------------------------------------------------------
    |
    */
	'modifiable' => [
		'places',
		'alerts',
		'comments',
		'photos',
		'users',
		'devices',
		'pets',
		'groups',
		'geofences'
	],
	/*
    |--------------------------------------------------------------------------
    | Removable
    |--------------------------------------------------------------------------
    |
    */
	'removable' => [
		'places' => \App\Models\Place::class,
		'photos' => \App\Models\Photo::class,
		'users' => \App\Models\User::class,
		'comments' => \App\Models\Comment::class,
		'actions' => \App\Models\Action::class,
		'devices' => \App\Models\Device::class,
		'pets' => \App\Models\Pet::class,
		'geofences' => \App\Models\Geofence::class,
		'groups' => \App\Models\Group::class,
		'alerts' => \App\Models\Alert::class
	],
	/*
    |--------------------------------------------------------------------------
    | Tokenized
    |--------------------------------------------------------------------------
    |
    */
	'tokenized' => [
		'pets',
		'devices',
	],
];
