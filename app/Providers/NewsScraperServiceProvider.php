<?php

namespace App\Providers;

use App\Services\NewsScraperService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

use App\Repositories\NewsScraper\NewsScraperRepository;

/**
 * Class NewsScraperServiceProvider
 * @package App\Providers
 */
class NewsScraperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        parent::boot();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NewsScraperService::class, function ($app) {
            return new NewsScraperService($app->make(NewsScraperRepository::class), $app->make(Client::class));
        });

//        $this->app->bind(
//            NewsScraperService::class,
//            function ($app) {
//                return new NewsScraperService(
//                    $app->make(NewsScraperRepository::class)
//                );
//            }
//        );
    }
}
