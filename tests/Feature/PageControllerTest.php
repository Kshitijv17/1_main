<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_about_us_page()
    {
        $this->get(route('user.aboutUs'))
             ->assertOk()
             ->assertViewIs('user.pages.about-us');
    }

    /** @test */
    public function it_displays_the_privacy_policy_page()
    {
        $this->get(route('user.privacyPolicy'))
             ->assertOk()
             ->assertViewIs('user.pages.privacy-policy');
    }

    /** @test */
    public function it_displays_the_terms_conditions_page()
    {
        $this->get(route('user.termsConditions'))
             ->assertOk()
             ->assertViewIs('user.pages.terms-conditions');
    }

    /** @test */
    public function it_displays_the_shipping_policy_page()
    {
        $this->get(route('user.shippingPolicy'))
             ->assertOk()
             ->assertViewIs('user.pages.shipping-policy');
    }

    /** @test */
    public function it_displays_the_return_policy_page()
    {
        $this->get(route('user.returnPolicy'))
             ->assertOk()
             ->assertViewIs('user.pages.return-policy');
    }

    /** @test */
    public function it_displays_the_refund_cancellation_page()
    {
        $this->get(route('user.refundCancellation'))
             ->assertOk()
             ->assertViewIs('user.pages.refund-cancellation');
    }
}