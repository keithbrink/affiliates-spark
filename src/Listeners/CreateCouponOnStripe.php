<?php

namespace KeithBrink\AffiliatesSpark\Listeners;

use KeithBrink\AffiliatesSpark\Events\AffiliateCreated;
use Stripe\Coupon;
use Stripe\Stripe;

class CreateCouponOnStripe
{
    public $affiliate_plan;
    public $coupon = [];

    public function handle(AffiliateCreated $event)
    {
        $this->affiliate_plan = $event->affiliate->plan;
        $this->affiliate = $event->affiliate;

        if ($this->affiliate->hasDiscount()) {
            // If no discount is set, don't create a coupon
            return;
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $this->setDuration();
        $this->setToken();
        $this->setDiscount();

        Coupon::create($this->coupon);
    }

    public function setDuration()
    {
        if ($this->affiliate_plan->months_of_discount == 0) {
            $this->coupon['duration'] = 'forever';
        } elseif ($this->affiliate_plan->months_of_discount == 1) {
            $this->coupon['duration'] = 'once';
        } else {
            $this->coupon['duration'] = 'repeating';
            $this->coupon['duration_in_months'] = round($this->affiliate_plan->months_of_discount);
        }
    }

    public function setDiscount()
    {
        if ($this->affiliate_plan->discount_percentage) {
            $this->coupon['percent_off'] = round($this->affiliate_plan->discount_percentage);
        } elseif ($this->affiliate_plan->discount_amount) {
            $this->coupon['amount_off'] = round($this->affiliate_plan->discount_amount * 100);
            $this->coupon['currency'] = config('cashier.currency');
        } else {
            return false;
        }
    }

    public function setToken()
    {
        $this->coupon['id'] = $this->affiliate->token;
    }
}
