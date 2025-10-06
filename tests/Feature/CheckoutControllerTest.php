<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Session::start(); // Start session for tests
    }

    /** @test */
    public function unauthenticated_user_cannot_access_checkout_pages()
    {
        $order = Order::factory()->create();

        $this->get(route('user.checkout.show', $order->id))
             ->assertRedirect('/login'); // Assuming '/login' is the default login route

        $this->get(route('user.checkout.showMultiple'))
             ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_view_single_order_checkout_page()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user)
             ->get(route('user.checkout.show', $order->id))
             ->assertOk()
             ->assertViewIs('user.checkout')
             ->assertViewHas('order', function ($viewOrder) use ($order) {
                 return $viewOrder->id === $order->id;
             });
    }

    /** @test */
    public function authenticated_user_cannot_view_another_users_single_order_checkout_page()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $order = Order::factory()->for($anotherUser)->create();

        $this->actingAs($user)
             ->get(route('user.checkout.show', $order->id))
             ->assertStatus(403); // Unauthorized access
    }

    /** @test */
    public function authenticated_user_can_view_multiple_orders_checkout_page()
    {
        $user = User::factory()->create();
        $order1 = Order::factory()->for($user)->create();
        $order2 = Order::factory()->for($user)->create();

        $this->actingAs($user)
             ->get(route('user.checkout.showMultiple', ['orders' => "{$order1->id},{$order2->id}"]))
             ->assertOk()
             ->assertViewIs('user.checkout-multiple')
             ->assertViewHas('orders', function ($viewOrders) use ($order1, $order2) {
                 return $viewOrders->contains($order1) && $viewOrders->contains($order2);
             });
    }

    /** @test */
    public function authenticated_user_cannot_view_multiple_orders_checkout_page_with_another_users_order()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $order1 = Order::factory()->for($user)->create();
        $order2 = Order::factory()->for($anotherUser)->create();

        $this->actingAs($user)
             ->get(route('user.checkout.showMultiple', ['orders' => "{$order1->id},{$order2->id}"]))
             ->assertStatus(403); // Unauthorized access
    }

    /** @test */
    public function user_can_process_payment_for_an_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create([
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        $paymentData = [
            'order_id' => $order->id,
            'payment_method' => 'credit_card',
            'shipping_address' => [
                'address_line_1' => $this->faker->streetAddress,
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'zip_code' => $this->faker->postcode,
                'country' => $this->faker->countryCode,
            ],
            'billing_address' => [
                'address_line_1' => $this->faker->streetAddress,
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'zip_code' => $this->faker->postcode,
                'country' => $this->faker->countryCode,
            ],
        ];

        $this->actingAs($user)
             ->postJson(route('user.checkout.processPayment'), $paymentData)
             ->assertOk()
             ->assertJson([
                 'success' => true,
                 'message' => 'Order placed successfully!',
             ]);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('confirmed', $order->status);
        $this->assertNotNull($order->shipping_address);
        $this->assertNotNull($order->billing_address);
    }

    /** @test */
    public function user_cannot_process_payment_for_another_users_order()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $order = Order::factory()->for($anotherUser)->create();

        $paymentData = [
            'order_id' => $order->id,
            'payment_method' => 'credit_card',
            'shipping_address' => [
                'address_line_1' => $this->faker->streetAddress,
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'zip_code' => $this->faker->postcode,
                'country' => $this->faker->countryCode,
            ],
            'billing_address' => [
                'address_line_1' => $this->faker->streetAddress,
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'zip_code' => $this->faker->postcode,
                'country' => $this->faker->countryCode,
            ],
        ];

        $this->actingAs($user)
             ->postJson(route('user.checkout.processPayment'), $paymentData)
             ->assertStatus(403)
             ->assertJson([
                 'success' => false,
                 'message' => 'Unauthorized access to order',
             ]);
    }

    /** @test */
    public function user_can_view_order_success_page()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user)
             ->get(route('user.order.success', $order->id))
             ->assertOk()
             ->assertViewIs('user.order-success')
             ->assertViewHas('order', function ($viewOrder) use ($order) {
                 return $viewOrder->id === $order->id;
             });
    }

    /** @test */
    public function user_cannot_view_another_users_order_success_page()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $order = Order::factory()->for($anotherUser)->create();

        $this->actingAs($user)
             ->get(route('user.order.success', $order->id))
             ->assertStatus(403); // Unauthorized access
    }
}