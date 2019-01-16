<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Spark\Spark;
use Laravel\Spark\LocalInvoice;

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
}
