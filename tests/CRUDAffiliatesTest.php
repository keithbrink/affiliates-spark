<?php

namespace KeithBrink\AffiliatesSpark\Tests;

use KeithBrink\AffiliatesSpark\Mail\AffiliateUserCreated;
use Mail;

class CRUDAffiliatesTest extends TestCase
{
    public function testCreateAffiliate()
    {
        $token = str_random(10);

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $this->customer_user->email,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('affiliates', [
            'user_id' => $this->customer_user->id,
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
    }

    public function testCreateAffiliateUser()
    {
        $token = str_random(10);

        Mail::fake();

        $response = $this->actingAs($this->admin_user)->post('/affiliates-spark/kiosk/affiliates/add', [
            'user_email' => $token.'@test.com',
            'token' => $token,
            'affiliate_plan_id' => $this->affiliate_plan->id,
        ]);
        $response->assertStatus(200);

        Mail::assertQueued(AffiliateUserCreated::class, function ($mail) use ($token) {
            return $mail->user_email === $token.'@test.com';
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
        $name = str_random(10);

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
