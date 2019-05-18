<?php

namespace KeithBrink\AffiliatesSpark\Observers;

use KeithBrink\AffiliatesSpark\Interactions\CreditAffiliateFromInvoice;

class LocalInvoiceObserver
{
    public function created($invoice)
    {
        $interaction = new CreditAffiliateFromInvoice($invoice);
        $interaction->handle();
    }
}
