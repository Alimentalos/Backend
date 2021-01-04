<?php

use Alimentalos\Relationships\Models\User;
use App\Repositories\AdminRepository;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

if (! function_exists('authenticated')) {
	/**
	 * @return Authenticatable|User
	 */
    function authenticated()
    {
    	return Auth::user();
    }
}
if (! function_exists('rhas')) {
    /**
     * Check if request has key.
     *
     * @param $key
     * @return bool
     */
    function rhas($key)
    {
        return request()->has($key);
    }
}
if (! function_exists('einput')) {
    /**
     * Extract exploded input.
     *
     * @param $delimiter
     * @param $key
     * @return array
     */
    function einput($delimiter, $key)
    {
        return explode($delimiter, request()->input($key));
    }
}
if (! function_exists('input')) {
    /**
     * Extract request input.
     *
     * @param $key
     * @return mixed
     */
    function input($key)
    {
        return request()->input($key);
    }
}
if (! function_exists('uploaded')) {
    /**
     * Extract request file.
     *
     * @param $key
     * @return mixed
     */
    function uploaded($key)
    {
        return request()->file($key);
    }
}
if (! function_exists('only')) {
    function only($keys)
    {
        return request()->only(func_get_args());
    }
}
if (! function_exists('admin')) {
    /**
     * @return AdminRepository
     */
    function admin() {
        return new AdminRepository();
    }
}
if (! function_exists('create_admin')) {
    /**
     * @return User
     */
    function create_admin() {
        $user = User::factory()->create();
        $user->email = 'iantorres@outlook.com';
        $user->save();
        return $user;
    }
}
if (! function_exists('change_instance_user')) {
    /**
     * @param $instance
     * @param $user
     * @return void
     */
    function change_instance_user(Model $instance, User $user) {
        $instance->user_uuid = $user->uuid;
        $instance->save();
    }
}
if (! function_exists('change_instances_user')) {
    /**
     * @param Collection $instances
     * @param User $user
     * @return void
     */
    function change_instances_user(Collection $instances, User $user) {
        $instances->each(function ($instance) use ($user) {
            change_instance_user($instance, $user);
        });
    }
}
if (! function_exists('create_default_polygon')) {
    function create_default_polygon()
    {
        return new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
    }
}

if (! function_exists('default_pagination_fields')) {
    function default_pagination_fields()
    {
        return [
            'current_page',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ];
    }
}

if (! function_exists('create_location_payload')) {
    function create_location_payload($location, $latitude, $longitude)
    {
        return [
            'uuid' => $location->uuid,
            'coords' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'accuracy' => $location->accuracy,
                'altitude' => $location->altitude,
                'speed' => $location->speed,
                'heading' => $location->heading,
            ],
            'odometer' => $location->odometer,
            'event' => $location->event,
            'activity' => [
                'type' => $location->activity_type,
                'confidence' => $location->activity_confidence,
            ],
            'battery' => [
                'level' => $location->battery_level,
                'is_charging' => $location->battery_is_charging,
            ],
            'is_moving' => $location->is_moving,
            'timestamp' => time(),
        ];
    }
}
