<?php

use Faker\Generator as Faker;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;

$factory->define(AffiliatePlan::class, function (Faker $faker) {
    return [
        'name' => $faker->slug,
        'months_of_commission' => $faker->randomFloat(0,0,24),
        'commission_percentage' => $faker->randomFloat(0,0,50),
        'commission_amount' => $faker->randomFloat(2,0,5),
        'level_2_months_of_commission' => $faker->randomFloat(0,0,24),
        'level_2_commission_percentage' => $faker->randomFloat(0,0,50),
        'level_2_commission_amount' => $faker->randomFloat(2,0,5),
        'months_of_discount' => $faker->randomFloat(0,0,24),
        'discount_percentage' => $faker->randomFloat(0,0,50),
        'discount_amount' => $faker->randomFloat(2,0,5),
    ];
});
