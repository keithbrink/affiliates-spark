<?php

namespace KeithBrink\AffiliatesSpark\Tests;

use Laravel\Cashier\Cashier;

class ControllersTest extends TestCase
{
    public function testViewAffiliates()
    {
        $response = $this->actingAs($this->affiliate_user)->get('/affiliates');
        $response->assertStatus(200);

        $currency_string = Cashier::usesCurrencySymbol().number_format($this->affiliate->commissionAmount()->value(), 2);

        $response->assertSeeText('You receive a '.$currency_string.' commission');
        $response->assertSee(Cashier::usesCurrencySymbol());
        $response->assertDontSee('£');

        Cashier::useCurrency('gbp', '£');

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates');
        $response->assertStatus(200);

        $currency_string = Cashier::usesCurrencySymbol().number_format($this->affiliate->commissionAmount()->value(), 2);

        $response->assertSeeText('You receive a '.$currency_string.' commission');
        $response->assertSee(Cashier::usesCurrencySymbol());
        $response->assertDontSee('$');
    }

    public function testViewAffiliateTransactions()
    {
        $this->addAffiliateTransaction();

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/transactions');
        $response->assertStatus(200);

        $response->assertSee(Cashier::usesCurrencySymbol());
        $response->assertDontSee('£');

        Cashier::useCurrency('gbp', '£');

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/transactions');
        $response->assertStatus(200);

        $response->assertSee(Cashier::usesCurrencySymbol());
        $response->assertDontSee('$');
    }

    public function testViewAffiliateWithdraw()
    {
        $this->addAffiliateTransaction();

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/withdraw');
        $response->assertStatus(200);

        $response->assertSee(Cashier::usesCurrencySymbol());
        $response->assertDontSee('£');

        Cashier::useCurrency('gbp', '£');

        $response = $this->actingAs($this->affiliate_user)->get('/affiliates/withdraw');
        $response->assertStatus(200);

        $response->assertSee(Cashier::usesCurrencySymbol());
        $response->assertDontSee('$');
    }
}
