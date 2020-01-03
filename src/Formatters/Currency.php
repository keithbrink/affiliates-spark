<?php

namespace KeithBrink\AffiliatesSpark\Formatters;

use Laravel\Cashier\Cashier;

class Currency
{
    public $amount;

    public function __construct($amount)
    {
        $this->amount = (float) $amount;
    }

    public function __toString()
    {
        return Cashier::formatAmount($this->amount);
    }

    public function value()
    {
        return $this->amount;
    }
}
