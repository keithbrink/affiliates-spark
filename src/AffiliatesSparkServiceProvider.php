<?php

namespace KeithBrink\AffiliatesSpark;

use Laravel\Spark\LocalInvoice;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use KeithBrink\AffiliatesSpark\Observers\LocalInvoiceObserver;

class AffiliatesSparkServiceProvider extends ServiceProvider
{
    public $listeners = [
        'KeithBrink\AffiliatesSpark\Events\AffiliateCreated' => [
            'KeithBrink\AffiliatesSpark\Listeners\CreateCouponOnStripe',
        ],
    ];

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

        $this->publishes([
            __DIR__.'/resources/views/affiliates' => resource_path('views/vendor/affiliates-spark/affiliates'),
        ], 'views');

        $this->publishes([
            __DIR__.'/resources/views/emails' => resource_path('views/vendor/affiliates-spark/emails'),
        ], 'views');

        $this->publishes([
            __DIR__.'/resources/views/kiosk' => resource_path('views/vendor/affiliates-spark/kiosk'),
        ], 'views');

        $this->publishes([
            __DIR__.'/resources/views/nav' => resource_path('views/vendor/affiliates-spark/nav'),
        ], 'views');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'affiliates-spark');        

        $this->registerEventListeners();
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

    public function registerEventListeners()
    {
        LocalInvoice::observe(LocalInvoiceObserver::class);

        foreach($this->listeners as $event => $listeners) {
            foreach($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }        
    }
}
