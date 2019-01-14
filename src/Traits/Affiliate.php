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

    public function planName()
    {
        if ($this->subscribed()) {
            $subscriptions = $this->subscriptions()->get();
            $plan = '';
            foreach ($subscriptions as $subscription) {
                if (is_null($subscription->ends_at)) {
                    return $subscription->stripe_plan;
                } elseif (Carbon::now()->lt(Carbon::parse($subscription->ends_at))) {
                    return $subscription->stripe_plan;
                }
            }
        }
        return 'free';
    }
}