<?php

namespace KeithBrink\AffiliatesSpark\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Spark\Spark;
use Carbon\Carbon;

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
        return $this->hasMany(Spark::userModel(), 'affiliate_id');
    }

    public function teamReferrals()
    {
        return $this->hasMany(Spark::teamModel(), 'affiliate_id');
    }

    public function recurringRevenueByInterval($interval)
    {
        $total = 0;

        $plans = $interval == 'monthly' ? Spark::allMonthlyPlans() : Spark::allYearlyPlans();

        foreach ($plans as $plan) {
            $total += $this->getRecurringRevenueByPlan($plan, 'subscriptions', 'userReferrals', 'user_id');
            $total += $this->getRecurringRevenueByPlan($plan, 'team_subscriptions', 'teamReferrals', 'team_id');
        }

        return ($total*$this->commissionPercentage());
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
        return ($amount * $this->commissionPercentage()) + $this->commissionAmount();
    }

    public function commissionPercentage()
    {
        return ($this->plan->commission_percentage/100);
    }

    public function commissionAmount()
    {
        return $this->plan->commission_amount;
    }

    public function discountPercentage()
    {
        return ($this->plan->discount_percentage/100);
    }

    public function discountAmount()
    {
        return $this->plan->discount_amount;
    }

    public function monthlyRecurring()
    {
        return $this->recurringRevenueByInterval('monthly') + ($this->recurringRevenueByInterval('yearly') / 12);
    }

    public function yearlyRecurring()
    {
        return $this->monthlyRecurring() * 12;
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
                    $plans[$referral->planName()] += 1;
                } else {
                    $plans[$referral->planName()] = 1;
                }
            }
        }
        return $plans;
    }

    public function balance()
    {
        return $this->transactions()->sum('amount');
    }
}
