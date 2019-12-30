<?php

namespace KeithBrink\AffiliatesSpark\Formatters;

use Laravel\Cashier\Cashier;

class Currency
{
    public $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function __toString()
    {
        return config('cashier.currency') . number_format($this->amount, 2);
    }

    public function value()
    {
        return (float) $this->amount;
    }
}
