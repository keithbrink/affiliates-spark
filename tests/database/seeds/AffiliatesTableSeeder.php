<?php

namespace AffiliatesSpark\Tests\Database\Seeds;

use Illuminate\Database\Seeder;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;
use KeithBrink\AffiliatesSpark\Models\Affiliate;

class AffiliatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(Affiliate::class)->create([
            'user_id' => \DB::table('users')->where('email', '!=', 'keith@jasaratech.com')->inRandomOrder()->first()->id,
            'affiliate_plan_id' => AffiliatePlan::inRandomOrder()->first()->id,
        ]);
    }
}
