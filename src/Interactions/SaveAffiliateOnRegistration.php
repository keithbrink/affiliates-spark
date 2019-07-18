<?php

namespace KeithBrink\AffiliatesSpark\Interactions;

use Laravel\Spark\Spark;
use Carbon\Carbon;
use KeithBrink\AffiliatesSpark\Models\Affiliate;
use Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod\RedeemCoupon;
use Laravel\Spark\Repositories\UserRepository;
use Laravel\Spark\Events\Teams\TeamCreated;
use Laravel\Spark\Repositories\TeamRepository;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\AddTeamMember as AddTeamMemberContract;
use Illuminate\Http\Request;

class SaveAffiliateOnRegistration
{
    public function createUser(Request $request, $extra_data = [])
    {
        $data = array_merge($request->only(['name', 'email', 'password']), $extra_data);
        $data['password'] = bcrypt($data['password']);
        $data['last_read_announcements_at'] = Carbon::now();
        $data['trial_ends_at'] = Carbon::now()->addDays(Spark::trialDays());

        if($affiliate = $this->getAffiliate($request)) {
            $data['affiliate_id'] = $affiliate->id;
        }
        
        $user = Spark::user();

        $user->forceFill($data)->save();

        if ($affiliate) {
            $user->createAsStripeCustomer(null);

            Spark::interact(RedeemCoupon::class, [
                $user, $affiliate->token
            ]);
        }

        return $user;
    }

    public function createTeam($user, $data)
    {
        $attributes = [
            'owner_id' => $user->id,
            'name' => $data['name'],
            'trial_ends_at' => Carbon::now()->addDays(Spark::teamTrialDays()),
        ];

        if($affiliate = Affiliate::find($user->affiliate_id)) {
            $attributes['affiliate_id'] = $affiliate->id;
        }

        if (Spark::teamsIdentifiedByPath()) {
            $attributes['slug'] = $data['slug'];
        }

        $team = Spark::team()->forceCreate($attributes);

        event(new TeamCreated($team));

        Spark::interact(AddTeamMemberContract::class, [
            $team, $user, 'owner'
        ]);

        if ($affiliate) {
            Spark::interact(RedeemCoupon::class, [
                $team, $affiliate->token
            ]);
        }

        return $team;
    }

    public function getAffiliateId($request)
    {
        if ($request->cookie('affiliate')) {
            if (Affiliate::where('token', $request->cookie('affiliate'))->count()) {
                return Affiliate::where('token', $request->cookie('affiliate'))->first()->id;
            }
        }
    }
}
