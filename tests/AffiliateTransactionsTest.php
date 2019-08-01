<?php

namespace KeithBrink\AffiliatesSpark\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AffiliateTransactionsTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreditAffiliateForSubscription()
    {
        $this->addAffiliateTransaction();

        $commission_amount = $this->affiliate->calculateCommission($this->invoice->total)->value();

        $this->assertDatabaseHas('affiliate_transactions', [
            'affiliate_id' => $this->affiliate->id,
            'invoice_id' => $this->invoice->id,
            'transaction_date' => $this->invoice->created_at->toDateTimeString(),
            'type' => 'referral_payment',
            'amount' => round(($commission_amount), 2),
        ]);
    }
}
