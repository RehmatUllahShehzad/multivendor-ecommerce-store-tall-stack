<?php

namespace App\Providers;

use App\Events\Frontend\OrderPlaced;
use App\Listeners\CartSessionAuthListener;
use App\Listeners\CreateStripeCustomer;
use App\Listeners\Frontend\SendOrderPlacedNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            CreateStripeCustomer::class,
            // SendEmailVerificationNotification::class,
        ],
        Login::class => [
            [CartSessionAuthListener::class, 'login'],
        ],
        Logout::class => [
            [CartSessionAuthListener::class, 'logout'],
        ],
        OrderPlaced::class => [
            SendOrderPlacedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
