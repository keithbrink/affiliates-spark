<?php

namespace KeithBrink\AffiliatesSpark\Tests\Database\Seeds;

use Illuminate\Database\Seeder;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;

class AffiliatePlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AffiliatePlan::class, 3)->create();
    }
}
