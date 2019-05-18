<?php

namespace KeithBrink\AffiliatesSpark;

use Laravel\Spark\LocalInvoice;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use KeithBrink\AffiliatesSpark\Observers\LocalInvoiceObserver;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use KeithBrink\AffiliatesSpark\Helpers\StaticOptions;

class AffiliatesSparkServiceProvider extends ServiceProvider
{
    public $listeners = [
        'KeithBrink\AffiliatesSpark\Events\AffiliateCreated' => [
            'KeithBrink\AffiliatesSpark\Listeners\CreateCouponOnStripe',
        ],
        'KeithBrink\AffiliatesSpark\Events\AffiliateUserCreated' => [
            'KeithBrink\AffiliatesSpark\Listeners\EmailRegistrationDetailsToAffiliateUser',
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
            __DIR__ . '/../config/affiliates-spark.php' => config_path('affiliates-spark.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/js' => resource_path('js/affiliates-spark'),
        ], 'javascript');

        $this->publishes([
            __DIR__ . '/resources/views/affiliates' => resource_path('views/vendor/affiliates-spark/affiliates'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/resources/views/emails' => resource_path('views/vendor/affiliates-spark/emails'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/resources/views/kiosk' => resource_path('views/vendor/affiliates-spark/kiosk'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/resources/views/nav' => resource_path('views/vendor/affiliates-spark/nav'),
        ], 'views');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'affiliates-spark');

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

        if (config('app.env') != 'production') {
            $this->registerEloquentFactoriesFrom(__DIR__ . '/../database/factories');
        }
    }

    public function registerEventListeners()
    {
        $invoice_model = StaticOptions::invoiceModel();
        $invoice_model::observe(LocalInvoiceObserver::class);

        foreach ($this->listeners as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}
