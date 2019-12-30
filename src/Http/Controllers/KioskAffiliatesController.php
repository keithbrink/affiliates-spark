<?php

namespace KeithBrink\AffiliatesSpark\Http\Controllers;

use KeithBrink\AffiliatesSpark\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use KeithBrink\AffiliatesSpark\Models\AffiliatePlan;
use KeithBrink\AffiliatesSpark\Events\AffiliateCreated;
use KeithBrink\AffiliatesSpark\Helpers\StaticOptions;
use KeithBrink\AffiliatesSpark\Events\AffiliateUserCreated;

class KioskAffiliatesController extends BaseController
{
    public function getAffiliates()
    {
        $affiliates_query = Affiliate::all();
        $affiliates = [];
        foreach ($affiliates_query as $affiliate) {
            $affiliates[] = [
                'id' => $affiliate->id,
                'name' => $affiliate->user->name,
                'plans' => $affiliate->planCounts(),
            ];
        }

        return response()->json($affiliates);
    }

    public function getPlans()
    {
        $affilate_plans = AffiliatePlan::all();

        return response()->json($affilate_plans->toArray());
    }

    /**
     * Check if there is a user with the given email address.
     */
    public function getCheckUser(Request $request)
    {
        if ($user = User::where('email', $request->email)->first()) {
            return response('User found.', 200);
        }
    }

    public function postAddAffiliate(Request $request)
    {
        if (!$request->token) {
            $request->merge(['token' => Str::random(12)]);
        }

        $request->validate([
            'user_email' => 'required',
            'token' => 'unique:affiliates,token|alpha_dash',
            'affiliate_plan_id' => 'required|exists:affiliate_plans,id',
        ]);        

        if ($user = StaticOptions::user()->where('email', $request->user_email)->first()) {
            if (Affiliate::where('user_id', $user->id)->count()) {
                return response('User is already an affiliate.', 422);
            }
        } else {
            $user = $this->createAffiliateUser($request->user_email, $request->token);
        }

        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'token' => $request->token,
            'affiliate_plan_id' => $request->affiliate_plan_id,
        ]);

        event(new AffiliateCreated($affiliate));

        return response(200);
    }

    public function postAddPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:affiliate_plans,name',
            'months_of_commission' => 'required|integer|min:0|max:999',
            'commission_percentage' => 'integer|min:0|max:100',
            'commission_amount' => 'numeric|min:0',
            'months_of_discount' => 'integer|min:0|max:999',
            'discount_percentage' => 'integer|min:0|max:100',
            'discount_amount' => 'numeric|min:0',
            'level_2_months_of_commission' => 'integer|min:0|max:999',
            'level_2_commission_percentage' => 'integer|min:0|max:100',
            'level_2_commission_amount' => 'numeric|min:0',
        ]);

        $affiliate_plan = AffiliatePlan::create($request->except(['busy', 'errors', 'successful']));

        return response(200);
    }

    private function createAffiliateUser($email, $name)
    {
        $password = Str::random(12);

        $user = StaticOptions::createUser([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        event(new AffiliateUserCreated($user, $password));

        return $user;
    }
}
