<?php

namespace App\Providers;

use App\Models\Property;
use App\Policies\PropertyPolicy;
use App\Services\AuthServices\AuthLoginService;
use App\Services\AuthServices\AuthLoginServiceInterface;
use App\Services\AuthServices\AuthLogoutService;
use App\Services\AuthServices\AuthLogoutServiceInterface;
use App\Services\AuthServices\AuthRegisterService;
use App\Services\AuthServices\AuthRegisterServiceInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Property::class => PropertyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        app()->bind(AuthRegisterServiceInterface::class, AuthRegisterService::class);
        app()->bind(AuthLoginServiceInterface::class, AuthLoginService::class);
        app()->bind(AuthLogoutServiceInterface::class, AuthLogoutService::class);
    }
}
