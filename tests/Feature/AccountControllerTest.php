<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function authenticated_user_can_view_account_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.my-account'));

        $response->assertStatus(200);
        $response->assertViewIs('user.pages.my-account');
        $response->assertViewHas('user', $user);
        $response->assertViewHas('recentOrders');
    }

    /** @test */
    public function unauthenticated_user_cannot_view_account_dashboard()
    {
        $response = $this->get(route('user.my-account'));

        $response->assertRedirect(route('user.login'));
    }

    /** @test */
    public function authenticated_user_can_view_their_orders()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->get(route('user.orders'));

        $response->assertStatus(200);
        $response->assertViewIs('user.pages.my-orders');
        $response->assertViewHas('orders');
        $this->assertCount(3, $response->viewData('orders'));
    }

    /** @test */
    public function unauthenticated_user_cannot_view_their_orders()
    {
        $response = $this->get(route('user.orders'));

        $response->assertRedirect(route('user.login'));
    }
}