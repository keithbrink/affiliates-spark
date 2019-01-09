<?php

namespace KeithBrink\AffiliatesSpark\Interactions;

use KeithBrink\AffiliatesSpark\Models\affiliateTransaction;
use Laravel\Spark\LocalInvoice;

class CreditAffiliateFromInvoice
{
    public $invoice;

    public function __construct(LocalInvoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function handle()
    {
        if ($affiliate_id = $this->invoice->user->affiliate_id) {
            $transaction = new AffiliateTransaction;
            $transaction->affiliate_id = $affiliate_id;
            $transaction->transaction_date = $this->invoice->created_at;
            $transaction->transaction_id = $this->invoice->id;
            $transaction->type = 'referral_payment';
            $transaction->amount = round($this->invoice->total*0.33, 1);
            $transaction->save();
        }
    }
}
