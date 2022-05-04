<?php

namespace App\Providers;

use App\Contracts\Services\LpSaveInstantInterface;
use App\Contracts\Services\Select2ServiceInterface;
use App\Services\LpSaveInstantService;
use App\Services\Select2Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LpSaveInstantInterface::class, function ($app, $parameter = []) {
            return new LpSaveInstantService($parameter[0]);
        });

        $this->app->bind(Select2ServiceInterface::class, function ($app) {
            return new Select2Service();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
