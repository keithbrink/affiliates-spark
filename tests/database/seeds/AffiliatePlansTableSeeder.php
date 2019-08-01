<?php

namespace AffiliatesSpark\Tests\Database\Seeds;

use Illuminate\Database\Seeder;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;

class AffiliatePlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(AffiliatePlan::class, 3)->create();
    }
}
