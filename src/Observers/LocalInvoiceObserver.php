<?php

namespace KeithBrink\SegmentSpark\Observers;

use Laravel\Spark\LocalInvoice;
use KeithBrink\AffiliatesSpark\Listeners\CreditAffiliateFromInvoice;

class LocalInvoiceObserver
{
    public function created(LocalInvoice $invoice)
    {
        $interaction = new CreditAffiliateFromInvoice($invoice);
        $interaction->handle();
    }
}
