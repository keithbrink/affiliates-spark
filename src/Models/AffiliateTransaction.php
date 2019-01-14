<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Spark\Spark;

class AffiliateTransaction extends Model
{
    public function affiliate()
    {
        return $this->belongsTo(Spark::userModel());
    }
}
