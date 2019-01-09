<?php

namespace Keithbrink\SegmentSpark\Observers;

use Cache;
use Segment;
use Laravel\Spark\Spark;
use Laravel\Spark\LocalInvoice;

class LocalInvoiceObserver
{
    public $context = [];

    /**
     * Get the Google Analytics Client ID to send to Segment
     * from the cached result from the user event subscriber.
     */
    public function getContext($user_id)
    {
        if (Cache::has('segment-spark-ga-client-id-user-id-'.$user_id)) {
            $client_id = Cache::get('segment-spark-ga-client-id-user-id-'.$user_id);
            $context = [
                'Google Analytics' => [
                    'clientId' => $client_id,
                ],
            ];

            return $context;
        }
    }

    public function created(LocalInvoice $invoice)
    {
        $discount_amount = $invoice->user->sparkPlan()->price - $invoice->total - $invoice->tax;
        if (Spark::$billsUsing == 'stripe' && $discount_amount > 0) {
            if ($discount = $invoice->user->asStripeCustomer()->discount) {
                $discount_code = $discount->coupon ? $discount->coupon->id : null;
            }
        }
        if ($invoice->user->localInvoices()->count() > 1) {
            $integrations = [
                'Google Analytics' => false,
            ];
        } else {
            $integrations = [
                'All' => true,
            ];
        }
        Segment::track([
            'userId' => $invoice->user->id,
            'event' => 'Order Completed',

            'properties' => [
                'products' => [[
                    'product_id' => $invoice->user->sparkPlan()->id,
                    'sku' => $invoice->user->sparkPlan()->id,
                    'name' => $invoice->user->sparkPlan()->name,
                    'price' => $invoice->user->sparkPlan()->price,
                    'quantity' => 1,
                ]],
                'order_id' => $invoice->id,
                'total' => $invoice->total,
                'tax' => $invoice->tax,
                'discount' => $invoice->user->sparkPlan()->price - $invoice->total - $invoice->tax,
                'coupon' => isset($discount_code) ? $discount_code : null,
            ],
            'integrations' => $integrations,
            'context' => $this->getContext($invoice->user->id),
        ]);
        Segment::flush();
    }
}
