<?php

namespace KeithBrink\AffiliatesSpark\Http\Controllers;

use KeithBrink\AffiliatesSpark\Models\Affiliate;
use App\Http\Controllers\Controller;
use Laravel\Spark\Spark;

class KioskAffiliatesController extends Controller
{
    public function index()
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
}
