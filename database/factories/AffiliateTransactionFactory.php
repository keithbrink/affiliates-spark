<?php

use Faker\Generator as Faker;
use KeithBrink\AffiliatesSpark\Models\Affiliate;
use KeithBrink\AffiliatesSpark\Models\AffiliateTransaction;

$factory->define(AffiliateTransaction::class, function (Faker $faker) {
    return [
        'affiliate_id' => $faker->randomElement(Affiliate::all()->pluck('id')->toArray()),
        'transaction_id' => str_random(10),
        'transaction_date' => $faker->dateTime(),
        'type' => $faker->randomElement(['referral_payment', 'withdrawal']),
        'amount' => $faker->randomFloat(2,0.1,100),
    ];
});
