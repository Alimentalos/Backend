<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Listable
    |--------------------------------------------------------------------------
    |
    */
	'listable' => [
		'places' => \Alimentalos\Relationships\Models\Place::class,
		'users' => \Alimentalos\Relationships\Models\User::class,
		'groups' => \Alimentalos\Relationships\Models\Group::class,
		'geofences' => \Alimentalos\Relationships\Models\Geofence::class,
		'pets' => \Alimentalos\Relationships\Models\Pet::class,
		'devices' => \Alimentalos\Relationships\Models\Device::class,
		'photos' => \Alimentalos\Relationships\Models\Photo::class,
		'actions' => \Alimentalos\Relationships\Models\Action::class,
		'alerts' => \Alimentalos\Relationships\Models\Alert::class
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
		'places',
		'groups',
		'locations',
		'actions',
		'geofences',
		'pets',
		'devices',
		'users',
		'photos',
		'comments',
		'alerts'
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
		'places' => \Alimentalos\Relationships\Models\Place::class,
		'photos' => \Alimentalos\Relationships\Models\Photo::class,
		'users' => \Alimentalos\Relationships\Models\User::class,
		'comments' => \Alimentalos\Relationships\Models\Comment::class,
		'actions' => \Alimentalos\Relationships\Models\Action::class,
		'devices' => \Alimentalos\Relationships\Models\Device::class,
		'pets' => \Alimentalos\Relationships\Models\Pet::class,
		'geofences' => \Alimentalos\Relationships\Models\Geofence::class,
		'groups' => \Alimentalos\Relationships\Models\Group::class,
		'alerts' => \Alimentalos\Relationships\Models\Alert::class
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
