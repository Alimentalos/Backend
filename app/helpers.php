<?php

use Alimentalos\Relationships\Models\User;
use App\Repositories\AdminRepository;
use Illuminate\Contracts\Auth\Authenticatable;
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
