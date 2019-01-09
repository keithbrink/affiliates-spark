<?php

namespace KeithBrink\AffiliatesSpark\Traits;

trait Affiliate {

    public function affiliate()
    {
        return $this->hasMany('KeithBrink\AffiliatesSpark\Models\Affiliate');
    }

    public function isAffiliate()
    {
        if($this->affiliate()->count()) {
            return true;
        }
        return false;
    }
}