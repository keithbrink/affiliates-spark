<?php

namespace KeithBrink\AffiliatesSpark\Formatters;

use Symfony\Component\Intl\Currencies;

class Currency
{
    public $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function __toString()
    {
        return Currencies::getSymbol(strtoupper(config('cashier.currency')), config('cashier.currency_locale'));
    }

    public function value()
    {
        return (float) $this->amount;
    }
}
