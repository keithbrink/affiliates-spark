<?php

use Faker\Generator as Faker;
use KeithBrink\AffiliatesSpark\Models\Affiliate;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;
use Laravel\Spark\Spark;

$factory->define(Affiliate::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement(Spark::user()->pluck('id')->toArray()),
        'sub_affiliate_of_id' => 0,
        'affiliate_plan_id' => $faker->randomElement(AffiliatePlan::all()->pluck('id')->toArray()),
        'token' => str_random(10),
    ];
});
