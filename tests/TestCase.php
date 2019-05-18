<?php

namespace KeithBrink\AffiliatesSpark\Tests;

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
        $this->withFactories(__DIR__ . '../database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->artisan('migrate', [
            '--database' => 'testbench',
        ])->run();
        $this->artisan('db:seed', ['--class' => '\KeithBrink\AffiliatesSpark\Tests\Database\Seeds\DatabaseSeeder']);

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
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['router']->aliasMiddleware('dev', VerifyUserIsDeveloper::class);
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
