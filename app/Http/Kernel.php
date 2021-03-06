<?php

namespace App\Http;

use App\Http\Middleware\{Authenticate,
	CheckForMaintenanceMode,
	ConvertStringBooleans,
	ConvertStringOpacityToFloat,
	ConvertStringShape,
	CreateUserAction,
	EncryptCookies,
	RedirectIfAuthenticated,
	SetLanguage,
	TrimStrings,
	TrustProxies,
	VerifyCsrfToken};
use Illuminate\Auth\Middleware\{AuthenticateWithBasicAuth, Authorize, EnsureEmailIsVerified, RequirePassword};
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\{Http\Kernel as HttpKernel,
	Http\Middleware\ConvertEmptyStringsToNull,
	Http\Middleware\ValidatePostSize};
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\{Middleware\SubstituteBindings, Middleware\ThrottleRequests, Middleware\ValidateSignature};
use Illuminate\Session\{Middleware\AuthenticateSession, Middleware\StartSession};
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\Cors\Cors;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        TrustProxies::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
//        Cors::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            SetLanguage::class,
//            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
            CreateUserAction::class,
            ConvertStringBooleans::class,
            ConvertStringShape::class,
            ConvertStringOpacityToFloat::class
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        ThrottleRequests::class,
        AuthenticateSession::class,
        SubstituteBindings::class,
        Authorize::class,
        CreateUserAction::class,
    ];
}
