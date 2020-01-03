<?php

namespace KeithBrink\AffiliatesSpark\Tests;

class ControllersTest extends TestCase
{
    public function testViewAffiliates()
    {
        config(['cashier.currency' => 'usd']);

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates');
        $response->assertStatus(200);

        $currency_string = '$'.number_format($this->affiliate->commissionAmount()->value(), 2);

        $response->assertSeeText('You receive a '.$currency_string.' commission');
        $response->assertSee('$');
        $response->assertDontSee('£');

        config(['cashier.currency' => 'gbp']);

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates');
        $response->assertStatus(200);

        $currency_string = '£'.number_format($this->affiliate->commissionAmount()->value(), 2);

        $response->assertSeeText('You receive a '.$currency_string.' commission');
        $response->assertSee('£');
        $response->assertDontSee('$');
    }

    public function testViewAffiliateTransactions()
    {
        $this->addAffiliateTransaction();

        config(['cashier.currency' => 'usd']);

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/transactions');
        $response->assertStatus(200);

        $response->assertSee('$');
        $response->assertDontSee('£');

        config(['cashier.currency' => 'gbp']);

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/transactions');
        $response->assertStatus(200);

        $response->assertSee('£');
        $response->assertDontSee('$');
    }

    public function testViewAffiliateWithdraw()
    {
        $this->addAffiliateTransaction();

        config(['cashier.currency' => 'usd']);

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/withdraw');
        $response->assertStatus(200);

        $response->assertSee('$');
        $response->assertDontSee('£');

        config(['cashier.currency' => 'gbp']);

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/withdraw');
        $response->assertStatus(200);

        $response->assertSee('£');
        $response->assertDontSee('$');
    }
}
