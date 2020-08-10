<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use KeithBrink\AffiliatesSpark\Formatters\Currency;
use KeithBrink\AffiliatesSpark\Helpers\StaticOptions;
use Laravel\Spark\Spark;

class Affiliate extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Spark::userModel());
    }

    public function plan()
    {
        return $this->belongsTo('\KeithBrink\AffiliatesSpark\Models\AffiliatePlan', 'affiliate_plan_id');
    }

    public function transactions()
    {
        return $this->hasMany('\KeithBrink\AffiliatesSpark\Models\AffiliateTransaction');
    }

    public function userReferrals()
    {
        return $this->hasMany(StaticOptions::userModel(), 'affiliate_id');
    }

    public function teamReferrals()
    {
        return $this->hasMany(StaticOptions::teamModel(), 'affiliate_id');
    }

    public function recurringRevenueByInterval($interval)
    {
        $total = 0;

        $plans = $interval == 'monthly' ? StaticOptions::allMonthlyPlans() : StaticOptions::allYearlyPlans();

        foreach ($plans as $plan) {
            $total += $this->getRecurringRevenueByPlan($plan, 'subscriptions', 'userReferrals', 'user_id');
            $total += $this->getRecurringRevenueByPlan($plan, 'team_subscriptions', 'teamReferrals', 'team_id');
        }

        return $total * $this->commissionPercentage();
    }

    public function getRecurringRevenueByPlan($plan, $table, $relationship_function, $column)
    {
        return \DB::table($table)
            ->where('stripe_plan', $plan->id)
            ->whereIn($column, $this->$relationship_function()->pluck('id'))
            ->where(function ($query) {
                $query->whereNull('trial_ends_at')
                    ->orWhere('trial_ends_at', '<=', Carbon::now());
            })
            ->whereNull('ends_at')
            ->sum('quantity') * ($plan->price * (1 - $this->discountPercentage()));
    }

    public function calculateCommission($amount)
    {
        return new Currency(($amount * $this->commissionPercentage()) + $this->commissionAmount()->value());
    }

    public function commissionPercentage()
    {
        return $this->plan->commission_percentage / 100;
    }

    public function commissionDuration()
    {
        return $this->plan->months_of_commission;
    }

    public function commissionAmount()
    {
        return new Currency($this->plan->commission_amount);
    }

    public function discountPercentage()
    {
        return $this->plan->discount_percentage / 100;
    }

    public function discountAmount()
    {
        return new Currency($this->plan->discount_amount);
    }

    public function hasDiscount()
    {
        if ($this->discountPercentage() > 0 or $this->discountAmount()->value() > 0) {
            return true;
        }

        return false;
    }

    public function monthlyRecurring()
    {
        return new Currency($this->recurringRevenueByInterval('monthly') + ($this->recurringRevenueByInterval('yearly') / 12));
    }

    public function yearlyRecurring()
    {
        return new Currency($this->monthlyRecurring()->value() * 12);
    }

    public function referralCount()
    {
        return $this->userReferrals()->count() + $this->teamReferrals()->count();
    }

    public function freeReferralCount()
    {
        $count = 0;
        foreach (['userReferrals', 'teamReferrals'] as $relationship_function) {
            foreach ($this->$relationship_function()->get() as $referral) {
                if ($referral->planName() == 'free') {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function planCounts()
    {
        $plans = [];
        foreach (['userReferrals', 'teamReferrals'] as $relationship_function) {
            foreach ($this->$relationship_function()->get() as $referral) {
                if (array_key_exists($referral->planName(), $plans)) {
                    $plans[$referral->planName()]++;
                } else {
                    $plans[$referral->planName()] = 1;
                }
            }
        }

        return $plans;
    }

    public function balance()
    {
        return new Currency($this->transactions()->sum('amount'));
    }
}
