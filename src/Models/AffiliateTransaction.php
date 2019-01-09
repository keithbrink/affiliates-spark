<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateTransaction extends Model
{
    public function affiliate()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
