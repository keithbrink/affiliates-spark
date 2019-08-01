<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Spark\Spark;
use Laravel\Spark\LocalInvoice;
use KeithBrink\AffiliatesSpark\Formatters\Currency;

class AffiliateTransaction extends Model
{
    public function affiliate()
    {
        return $this->belongsTo(Spark::userModel());
    }

    public function invoice()
    {
        return $this->belongsTo(LocalInvoice::class);
    }

    public function formattedAmount()
    {
        return new Currency($this->amount);
    }
}
