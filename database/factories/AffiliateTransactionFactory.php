<?php

use Faker\Generator as Faker;
use KeithBrink\AffiliatesSpark\Models\Affiliate;
use KeithBrink\AffiliatesSpark\Models\AffiliateTransaction;

$factory->define(AffiliateTransaction::class, function (Faker $faker) {
    return [
        'affiliate_id' => $faker->randomElement(Affiliate::all()->pluck('id')->toArray()),
        'invoice_id' => rand(1, 99),
        'transaction_date' => $faker->dateTime(),
        'type' => $faker->randomElement(['referral_payment', 'withdrawal']),
        'amount' => $faker->randomFloat(2, 0.1, 100),
    ];
});
