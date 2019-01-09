<?php

namespace KeithBrink\AffiliatesSpark\Http\Controllers;

use KeithBrink\AffiliatesSpark\Models\Affiliate;
use App\Http\Controllers\Controller;

class KioskAffiliatesController extends Controller
{
    public function index()
    {
        $affiliates_query = Affiliate::all();
        $affiliates = [];
        foreach ($affiliates_query as $affiliate) {
            $affiliates[] = [
                'name' => $affiliate->user->name,
                'plans' => $affiliate->planCounts(),
            ];
        }

        return view('affiliates-spark::kiosk.affiliates', [
            'affiliates' => $affiliates,
        ]);
    }
}
