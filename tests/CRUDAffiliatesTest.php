<?php

namespace KeithBrink\AffiliatesSpark\Tests;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use KeithBrink\AffiliatesSpark\Events\AffiliateCreated;
use KeithBrink\AffiliatesSpark\Events\AffiliateUserCreated;

class CRUDAffiliatesTest extends TestCase
{
    public function testCreateAffiliateSpecificToken()
    {
        $token = Str::random(10);

        Event::fake();

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $this->customer_user->email,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(200);

        Event::assertDispatched(AffiliateCreated::class, function ($event) use ($token) {
            return $event->affiliate->token === $token;
        });

        $this->assertDatabaseHas('affiliates', [
            'user_id' => $this->customer_user->id,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
    }

    public function testCreateAffiliateRandomToken()
    {
        Event::fake();

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $this->customer_user->email,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(200);

        Event::assertDispatched(AffiliateCreated::class, function ($event) {
            return $event->affiliate->user_id === $this->customer_user->id;
        });

        $this->assertDatabaseHas('affiliates', [
            'user_id' => $this->customer_user->id,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
    }

    public function testCreateAffiliateFailsSameToken()
    {
        $token = Str::random(10);

        Event::fake();

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $this->customer_user->email,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(200);

        Event::assertDispatched(AffiliateCreated::class, function ($event) use ($token) {
            return $event->affiliate->token === $token;
        });

        $this->assertDatabaseHas('affiliates', [
            'user_id' => $this->customer_user->id,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);

        $this->withExceptionHandling();

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $this->customer_user->email,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['token']);
    }

    public function testCreateAffiliateUser()
    {
        $token = Str::random(10);

        Event::fake();

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $token.'@test.com',
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(200);

        Event::assertDispatched(AffiliateCreated::class, function ($event) use ($token) {
            return $event->affiliate->token === $token;
        });

        Event::assertDispatched(AffiliateUserCreated::class, function ($event) use ($token) {
            return $event->user->email === $token.'@test.com';
        });

        $this->assertDatabaseHas('users', [
            'name' => $token,
            'email' => $token.'@test.com',
        ]);

        $this->assertDatabaseHas('affiliates', [
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
    }

    public function testCreateAffiliatePlan()
    {
        $name = Str::random(10);

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/plans/add', [
            'name' => $name,
            'months_of_commission' => 0,
            'commission_percentage' => 40,
            'commission_amount' => 0,
            'discount_percentage' => 0,
            'discount_amount' => 0,
            'level_2_months_of_commission' => 0,
            'level_2_commission_percentage' => 0,
            'level_2_commission_amount' => 0,
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('affiliate_plans', [
            'name' => $name,
            'months_of_commission' => 0,
            'commission_percentage' => 40,
        ]);
    }
}
