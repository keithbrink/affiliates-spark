<?php

namespace KeithBrink\AffiliatesSpark\Observers;

use Laravel\Spark\LocalInvoice;
use KeithBrink\AffiliatesSpark\Interactions\CreditAffiliateFromInvoice;

class LocalInvoiceObserver
{
    public function created(LocalInvoice $invoice)
    {
        $interaction = new CreditAffiliateFromInvoice($invoice);
        $interaction->handle();
    }
}
