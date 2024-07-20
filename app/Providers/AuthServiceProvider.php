<?php

namespace App\Providers;

use App\Http\Middleware\Admin\Authenticate;
use App\Http\Middleware\AuthenticateVendor;
use App\Http\Middleware\RedirectIfAdminAuthenticated;
use App\Http\Middleware\RedirectIfUserNotActive;
use App\Http\Middleware\RedirectIfVendorAuthenticated;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerGates();

        $this->registerBladeDirectives();

        $this->registerAuthMiddlewareForLivewireRoutes();
    }

    public function registerGates(): void
    {
        Gate::after(function ($user, $ability) {
            return $user->is_admin;
        });
    }

    private function registerBladeDirectives(): void
    {
        Blade::directive('vendor', function () {
            return '<?php if ( Auth::check() && Auth::user()->isVendor()):  ?>';
        });

        Blade::directive('endVendor', function () {
            return '<?php endif;  ?>';
        });

        Blade::directive('customer', function () {
            return '<?php if ( Auth::check() && !Auth::user()->isVendor()):  ?>';
        });

        Blade::directive('endCustomer', function () {
            return '<?php endif; ?>';
        });
    }

    private function registerAuthMiddlewareForLivewireRoutes(): void
    {
        Livewire::addPersistentMiddleware([
            RedirectIfAdminAuthenticated::class,
            RedirectIfVendorAuthenticated::class,
            RedirectIfUserNotActive::class,
            Authenticate::class,
            AuthenticateVendor::class,
            PermissionMiddleware::class,
        ]);
    }
}
