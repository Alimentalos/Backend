<?php

namespace App\Http\Middleware;


use Closure;

class CreateUserAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth('api')->check()) {
            finder('resolve', $request);
        }

        $response = $next($request);

        return $response;
    }
}
