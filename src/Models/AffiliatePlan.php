<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatePlan extends Model
{
    public function affiliates()
    {
        return $this->belongsTo('\KeithBrink\AffiliatesSpark\Models\Affiliate');
    }
}
