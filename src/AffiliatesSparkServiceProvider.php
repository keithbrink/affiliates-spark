<?php

namespace KeithBrink\AffiliatesSpark;

use Laravel\Spark\LocalInvoice;
use Illuminate\Support\ServiceProvider;

class AffiliatesSparkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/affiliates-spark.php' => config_path('affiliates-spark.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js/affiliates-spark'),
        ], 'javascript');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'affiliates-spark');

        LocalInvoice::observe(LocalInvoiceObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('affiliates-spark-affiliate', \KeithBrink\AffiliatesSpark\Http\Middleware\Affiliate::class);
    }
}
