<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use KeithBrink\AffiliatesSpark\Models\Affiliate;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;

$factory->define(Affiliate::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement(\DB::table('users')->get()->pluck('id')->toArray()),
        'sub_affiliate_of_id' => 0,
        'affiliate_plan_id' => $faker->randomElement(AffiliatePlan::all()->pluck('id')->toArray()),
        'token' => Str::random(10),
    ];
});
