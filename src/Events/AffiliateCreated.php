<?php

namespace KeithBrink\AffiliatesSpark\Events;

use KeithBrink\AffiliatesSpark\Models\Affiliate;
use Illuminate\Queue\SerializesModels;

class AffiliateCreated {
    use SerializesModels;

    public $affiliate;

    public function __construct(Affiliate $affiliate)
    {
        $this->affiliate = $affiliate;
    }
}