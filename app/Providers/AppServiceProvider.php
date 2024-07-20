<?php

namespace App\Providers;

use App\Contracts\CartSessionInterface;
use App\Managers\PaymentManager;
use App\Services\Cart\CartSessionManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\ServiceProvider;
use Livewire\Testing\TestableLivewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(PaymentManager::class, function ($app) {
            return new PaymentManager($app);
        });

        $this->app->singleton(CartSessionInterface::class, function ($app) {
            return $app->make(CartSessionManager::class);
        });

        TestableLivewire::macro('uploadFile', function ($name, UploadedFile $file) {
            /** @var \Livewire\Testing\TestableLivewire */
            $response = $this;

            $response->set($name, $file);

            /** @var \Illuminate\Testing\TestResponse */
            $lastResponse = $response->lastResponse;

            foreach($lastResponse->original['effects']['emits'] ?? [] as $emit) {
                $response->emit($emit['event'], ...$emit['params']);
            }

            return $response;
        });
    }
}
