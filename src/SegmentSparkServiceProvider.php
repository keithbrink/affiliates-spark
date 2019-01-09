<?php

namespace Keithbrink\SegmentSpark;

use Config;
use Segment;
use Laravel\Spark\LocalInvoice;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Keithbrink\SegmentSpark\Listeners\UserEventSubscriber;
use Keithbrink\SegmentSpark\Observers\LocalInvoiceObserver;

class SegmentSparkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/segment-spark.php' => config_path('segment-spark.php'),
        ]);

        $this->publishes([
            __DIR__.'/resources/assets/js/segment-spark.js' => resource_path('assets/js/segment-spark.js'),
        ], 'resources');

        if ($write_key = $this->app->config->get('segment-spark.write_key')) {
            Segment::init($write_key);
        }

        LocalInvoice::observe(LocalInvoiceObserver::class);

        Event::subscribe(UserEventSubscriber::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
