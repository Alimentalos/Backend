<?php

namespace App\Http\Middleware;

use App\Repositories\HandleBindingRepository;
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
            HandleBindingRepository::resolve($request);
        }

        $response = $next($request);

        return $response;
    }
}
