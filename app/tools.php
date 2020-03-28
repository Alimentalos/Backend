<?php

use Alimentalos\Relationships\Models\User;
use Alimentalos\Tools\{Cataloger,
    Filler,
    Finder,
    Identifier,
    Liker,
    Measurer,
    Parameterizer,
    Parser,
    Reporter,
    Subscriber,
    Uploader};
use Illuminate\Contracts\Auth\Authenticatable;

if (! function_exists('subscriptions')) {
    /**
     * @return Subscriber
     */
    function subscriptions()
    {
        return new Subscriber();
    }
}
if (! function_exists('authenticated')) {
    /**
     * @param string $guard
     * @return Authenticatable|User
     */
    function authenticated($guard = 'api')
    {
        return auth($guard)->user();
    }
}
if (! function_exists('parameters')) {
    /**
     * @return Parameterizer
     */
    function parameters()
    {
        return new Parameterizer();
    }
}

if (! function_exists('uuid')) {
    /**
     * Get uuid.
     *
     * @return string
     */
    function uuid()
    {
        return Identifier::create();
    }
}
if (! function_exists('likes')) {
    /**
     * Get LikesRepository instance.
     *
     * @return Liker
     */
    function likes()
    {
        return new Liker();
    }
}
if (! function_exists('cataloger')) {
    /**
     * Get Cataloger instance.
     *
     * @return Cataloger
     */
    function cataloger()
    {
        return new Cataloger();
    }
}
if (! function_exists('fill')) {
    function fill($key, $value)
    {
        return Filler::make( $key, $value);
    }
}
if (! function_exists('parser')) {
    /**
     * @return Parser
     */
    function parser()
    {
        return new Parser();
    }
}
if (! function_exists('finder')) {
    /**
     * @return Finder
     */
    function finder() {
        return new Finder();
    }
}
if (! function_exists('upload')) {
    /**
     * @return Uploader
     */
    function upload() {
        return new Uploader();
    }
}
if (! function_exists('reports')) {
    /**
     * @return Reporter
     */
    function reports()
    {
        return new Reporter();
    }
}
if (! function_exists('measurer')) {
    /**
     * @return Measurer
     */
    function measurer()
    {
        return new Measurer();
    }
}
