<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CacheStoreInterface;
use App\Interfaces\APISourceInterface;
use App\Services\CacheService;
use App\Services\CrossRefAPIService;
use App\Services\PublicationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CacheStoreInterface::class, CacheService::class);
        $this->app->bind(APISourceInterface::class, CrossRefAPIService::class);

        $this->app->bind(PublicationService::class, function ($app) {
            return new PublicationService(
                $app->make(CacheStoreInterface::class),
                $app->make(APISourceInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
