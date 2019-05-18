<?php

namespace KeithBrink\AffiliatesSpark\Tests;

use KeithBrink\AffiliatesSpark\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use KeithBrink\AffiliatesSpark\Helpers\StaticOptions;

class AffiliateTransactionsTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreditAffiliateForSubscription()
    {
        $faker = \Faker\Factory::create();
        $this->customer_user->affiliate_id = $this->affiliate->id;
        $this->customer_user->save();

        $invoice = StaticOptions::invoiceModel()->create([
            'user_id' => $this->customer_user->id,
            'provider_id' => str_random(10),
            'total' => $faker->randomFloat(2, 5, 100),
            'tax' => $faker->randomFloat(2, 1, 5),
            'card_country' => $faker->countryCode,
            'billing_state' => $faker->state,
            'billing_zip' => $faker->postcode,
            'billing_country' => $faker->countryCode,
        ]);

        $commission_amount = $this->affiliate->calculateCommission($invoice->total);

        $this->assertDatabaseHas('affiliate_transactions', [
            'affiliate_id' => $this->affiliate->id,
            'invoice_id' => $invoice->id,
            'transaction_date' => $invoice->created_at->toDateTimeString(),
            'type' => 'referral_payment',
            'amount' => round(($commission_amount), 2),
        ]);
    }
}
