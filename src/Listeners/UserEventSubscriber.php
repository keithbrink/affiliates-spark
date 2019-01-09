<?php

namespace Keithbrink\SegmentSpark\Listeners;

use Cache;
use Segment;

class UserEventSubscriber
{
    /**
     * Handle user subscription added event.
     */
    public function onUserSubscribed($event)
    {
        Segment::track([
            'userId' => $event->user->id,
            'event' => 'Subscription Added',

            'properties' => [
                'products' => [[
                    'product_id' => $event->plan->id,
                    'sku' => $event->plan->id,
                    'name' => $event->plan->name,
                    'price' => $event->plan->price,
                    'quantity' => 1,
                ]],
            ],
            'context' => $this->getContext($event->user->id),
        ]);
        Segment::flush();
    }

    /**
     * Handle user subscription updated event.
     */
    public function onUserSubscriptionUpdated($event)
    {
        $plan = $event->user->sparkPlan();
        $subscription = $event->user->subscription();
        if ($subscription->active()) {
            Segment::track([
                'userId' => $event->user->id,
                'event' => 'Subscription Switched',
                'properties' => [
                    'products' => [[
                        'product_id' => $plan->id,
                        'sku' => $plan->id,
                        'name' => $plan->name,
                        'price' => $plan->price,
                        'quantity' => 1,
                    ]],
                ],
                'context' => $this->getContext($event->user->id),
            ]);
        }
        Segment::flush();
    }

    /**
     * Handle user subscription cancelled event.
     */
    public function onUserSubscriptionCancelled($event)
    {
        Segment::track([
            'userId' => $event->user->id,
            'event' => 'Subscription Cancelled',
            'context' => $this->getContext($event->user->id),
        ]);
    }

    /**
     * Handle user subscription cancelled event.
     */
    public function onUserRegistered($event)
    {
        Segment::track([
            'userId' => $event->user->id,
            'event' => 'User Registered',
            'context' => $this->getContext($event->user->id),
        ]);
    }

    /**
     * Get the Google Analytics Client ID to send to Segment.
     *
     * The client ID is cached so that it can also be associated
     * with the first invoice / order completion
     */
    public function getContext($user_id)
    {
        $client_id = null;
        if (Cache::has('segment-spark-ga-client-id-user-id-'.$user_id)) {
            $client_id = Cache::get('segment-spark-ga-client-id-user-id-'.$user_id);
        } elseif (request()->hasCookie('_ga')) {
            $client_id = str_replace('GA1.2.', '', request()->cookie('_ga'));
            Cache::put('segment-spark-ga-client-id-user-id-'.$user_id, $client_id, 1440);
        }
        if ($client_id) {
            $context = [
                'Google Analytics' => [
                    'clientId' => $client_id,
                ],
            ];

            return $context;
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Laravel\Spark\Events\Auth\UserRegistered',
            'Keithbrink\SegmentSpark\Listeners\UserEventSubscriber@onUserRegistered'
        );

        $events->listen(
            'Laravel\Spark\Events\Subscription\UserSubscribed',
            'Keithbrink\SegmentSpark\Listeners\UserEventSubscriber@onUserSubscribed'
        );

        $events->listen(
            'Laravel\Spark\Events\Subscription\SubscriptionUpdated',
            'Keithbrink\SegmentSpark\Listeners\UserEventSubscriber@onUserSubscriptionUpdated'
        );

        $events->listen(
            'Laravel\Spark\Events\Subscription\SubscriptionCancelled',
            'Keithbrink\SegmentSpark\Listeners\UserEventSubscriber@onUserSubscriptionCancelled'
        );
    }
}
