<?php

namespace KeithBrink\AffiliatesSpark\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use KeithBrink\AffiliatesSpark\Models\Affiliate;
use KeithBrink\AffiliatesSpark\Mail\AffiliateWithdrawalRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Mail;
use App\User;

class AffiliateController extends Controller
{
    public function index()
    {
        $affiliate = Affiliate::where('user_id', Auth::user()->id)->first();
        $monthly_recurring = $affiliate->monthlyRecurring();
        $yearly_recurring = $affiliate->yearlyRecurring();
        $referral_count = $affiliate->referralCount();
        $free_users = $affiliate->freeReferralCount();
        $affiliate_token = $affiliate->token;
        $plans = $affiliate->planCounts();

        return view('affiliates-spark::affiliates.home', [
            'monthly_recurring' => $monthly_recurring,
            'yearly_recurring' => $yearly_recurring,
            'referral_count' => $referral_count,
            'free_users' => $free_users,
            'affiliate_token' => $affiliate_token,
            'plans' => $plans,
        ]);
    }

    public function getTransactions()
    {
        $transactions = Affiliate::where('user_id', Auth::user()->id)->first()->transactions()->orderBy('transaction_date', 'DESC')->paginate(20);
        return view('affiliates-spark::affiliates.transactions', [
            'transactions' => $transactions,
        ]);
    }

    public function getWithdraw()
    {
        return view('affiliates-spark::affiliates.withdraw', [
            'balance' => Affiliate::where('user_id', Auth::user()->id)->first()->balance(),
        ]);
    }

    public function postWithdraw(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:10',
            'paypalEmail' => 'required|email',
        ]);
        if (Affiliate::where('user_id', Auth::user()->id)->first()->balance() < $request->input('amount')) {
            return redirect('/affiliates/withdraw')->withErrors([
                'amount' => 'You do not have this much available to withdraw.',
            ]);
        }

        $user->

        $send_email_to_user = Spark::user()->where('email', Spark::$developers[0])->first();

        Mail::to($send_email_to_user)->queue(new AffiliateWithdrawalRequest(
            Auth::user()->email, 
            $request->input('amount'), 
            $request->input('paypalEmail')
        ));

        return redirect('/affiliates/withdraw')->with([
            'withdrawal_message' => 'Your withdrawal request has been received and will be processed within 2 business days.',
        ]);
    }

    public function link($affiliate_token, Request $request)
    {
        $user_id = Auth::check() ? Auth::user()->id : str_random(40);
        Segment::page([
            "userId" => $user_id,
            "name" => "affiliate Redirect",
            "properties" => [
                "url" => "https://dashboard.azlabels.com/p/" . $affiliate_token,
            ],
            "context" => [
                "campaign" => [
                    "name" => $affiliate_token,
                    "source" => "affiliate",
                    "medium" => "referral",
                ],
            ],
            "integrations" => [
                "Google Analytics" => false,
            ],
        ]);
        if (strpos($affiliate_token, 'RF-') !== false) {
            $referral_url = 'http://azlabels.com';
        } else {
            switch ($affiliate_token) {
                case 'RCOSMAN_FLASH': // Flash sale
                    if (Carbon::parse('2018-09-26')->isFuture()) { // Flash sale expires on
                        $referral_url = 'http://azlabels.com/rcosman';
                    } else {
                        $affiliate_token = 'RCOSMAN'; //Post flash sale token
                        $referral_url = 'http://azlabels.com/affiliate';
                    }
                    break;
                case 'SF_FLASH_ANNUAL': // Expired flash sale
                    $referral_url = 'http://azlabels.com/affiliate';
                    $affiliate_token = 'SELLING_FAMILY';
                    break;
                case 'BW_FLASH_ANNUAL': // Expired flash sale
                    $referral_url = 'http://azlabels.com/affiliate';
                    $affiliate_token = 'BOBWILEY';
                    break;
                default:
                    $referral_url = 'http://azlabels.com/affiliate';
                    break;
            }
        }
        $referral_url .= '?ref=' . $affiliate_token . '&utm_source=affiliate&utm_medium=referral&utm_campaign=' . $affiliate_token;
        if (Affiliate::where('token', $affiliate_token)->count()) {
            if ($request->cookie('affiliate')) {
                return redirect($referral_url); // Do not set a new cookie, previous affiliateships should be honoured.
            } else {
                return redirect($referral_url)->cookie(
                    'affiliate',
                    $affiliate_token,
                    43200
                );
            }
        } else {
            return redirect('http://azlabels.com');
        }
    }

    public function setCookie(Request $request, $affiliate_token)
    {
        if (Affiliate::where('token', $affiliate_token)->count()) {
            if ($request->cookie('affiliate')) {
                return response('Cookie exists'); // Do not set a new cookie, previous affiliateships should be honoured.
            } else {
                return response('Cookie added.')->cookie(
                    'affiliate',
                    $affiliate_token,
                    43200
                );
            }
        } else {
            return response('No matching affiliate');
        }
    }

    public function showCookie(Request $request)
    {
        if ($request->cookie('affiliate')) {
            return response($request->cookie('affiliate'));
        } else {
            return response('No cookie set.');
        }
    }

    public function getJavascript()
    {
        $javascript = view('affiliates-spark::public-javascript.affiliates');
        return response($javascript)->header('Content-Type', 'application/javascript');
    }
}
