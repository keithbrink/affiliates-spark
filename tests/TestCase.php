<?php

namespace AffiliatesSpark\Tests;

use KeithBrink\AffiliatesSpark\Models\Affiliate;
use KeithBrink\AffiliatesSpark\Helpers\StaticOptions;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->withFactories(__DIR__.'../database/factories');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->artisan('migrate', [
            '--database' => 'testbench',
        ])->run();
        $this->artisan('db:seed', ['--class' => 'AffiliatesSpark\Tests\Database\Seeds\DatabaseSeeder']);

        $this->linkAllData();
    }

    protected function getPackageProviders($app)
    {
        return [
            \KeithBrink\AffiliatesSpark\AffiliatesSparkServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['router']->aliasMiddleware('dev', VerifyUserIsDeveloper::class);
        app('view')->addNamespace('spark', __DIR__.'/../src/resources/views/spark-stubs');
    }

    public function linkAllData()
    {
        $this->user_model = StaticOptions::user();
        $this->linkAffiliate();
        $this->linkCustomer();
        $this->admin_user = $this->user_model->where('email', 'keith@jasaratech.com')->first();
    }

    public function linkAffiliate()
    {
        $this->affiliate = Affiliate::inRandomOrder()->first();
        $this->affiliate_plan = $this->affiliate->plan;
        $this->affiliate_user = $this->user_model->find($this->affiliate->user_id);
    }

    public function linkCustomer()
    {
        $affiliate_user_ids = Affiliate::all()->pluck('user_id')->toArray();
        $this->customer_user = $this->user_model->whereNotIn('id', $affiliate_user_ids)->first();
    }

    public function addAffiliateTransaction($user_id = false)
    {
        $this->customer_user->affiliate_id = $this->affiliate->id;
        $this->customer_user->save();

        if (!$user_id) {
            $user_id = $this->customer_user->id;
        }

        $faker = \Faker\Factory::create();

        $this->invoice = StaticOptions::invoiceModel()->create([
            'user_id' => $user_id,
            'provider_id' => str_random(10),
            'total' => $faker->randomFloat(2, 5, 100),
            'tax' => $faker->randomFloat(2, 1, 5),
            'card_country' => $faker->countryCode,
            'billing_state' => $faker->state,
            'billing_zip' => $faker->postcode,
            'billing_country' => $faker->countryCode,
        ]);
    }
}

class VerifyUserIsDeveloper
{
    public function handle($request, $next)
    {
        if ($request->user() && $request->user()->email == 'keith@jasaratech.com') {
            return $next($request);
        }

        return $request->ajax() || $request->wantsJson()
            ? response('Unauthorized.', 401)
            : redirect()->guest('login');
    }
}
