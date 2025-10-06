<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Session::start(); // Start session for tests

        // Create a user, shop, category, and product for testing
        User::factory()->create(['id' => 1, 'name' => 'Test User', 'email' => 'test@example.com']);
        Shop::factory()->create(['id' => 1, 'name' => 'Test Shop', 'is_active' => true]);
        Category::factory()->create(['id' => 1, 'title' => 'Test Category']);
        Product::factory()->create([
            'id' => 1,
            'title' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'selling_price' => 90,
            'quantity' => 10,
            'category_id' => 1,
            'shop_id' => 1,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_view_orders_index()
    {
        $this->get(route('user.orders.index'))
             ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_view_their_orders()
    {
        $user = User::find(1);
        Order::factory()->for($user)->create();

        $this->actingAs($user)
             ->get(route('user.orders.index'))
             ->assertOk()
             ->assertViewIs('user.orders.index')
             ->assertViewHas('orders');
    }

    /** @test */
    public function unauthenticated_user_can_view_buy_now_form()
    {
        $product = Product::find(1);
        $this->get(route('user.buyNow', $product->id))
             ->assertOk()
             ->assertViewIs('user.buy-now')
             ->assertViewHas('product', $product)
             ->assertViewHas('finalPrice', 90);
    }

    /** @test */
    public function buy_now_form_redirects_if_product_is_unavailable()
    {
        $product = Product::factory()->create(['is_active' => false]);
        $this->get(route('user.buyNow', $product->id))
             ->assertRedirect()
             ->assertSessionHas('error', 'Product is not available for purchase.');
    }

    /** @test */
    public function unauthenticated_user_can_process_buy_now_order()
    {
        $product = Product::find(1);
        $initialProductQuantity = $product->quantity;

        $response = $this->post(route('user.processBuyNow', $product->id), [
            'quantity' => 1,
            'user_name' => $this->faker->name,
            'user_email' => $this->faker->email,
            'user_phone' => $this->faker->phoneNumber,
            'shipping_address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect(route('user.order.success', Order::first()))
                 ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id' => null, // Unauthenticated user
            'shop_id' => $product->shop_id,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $this->assertEquals($initialProductQuantity - 1, $product->fresh()->quantity);
    }

    /** @test */
    public function authenticated_user_can_process_buy_now_order()
    {
        $user = User::find(1);
        $product = Product::find(1);
        $initialProductQuantity = $product->quantity;

        $response = $this->actingAs($user)
                         ->post(route('user.processBuyNow', $product->id), [
                             'quantity' => 1,
                             'user_name' => $user->name,
                             'user_email' => $user->email,
                             'user_phone' => $this->faker->phoneNumber,
                             'shipping_address' => $this->faker->address,
                             'city' => $this->faker->city,
                             'postal_code' => $this->faker->postcode,
                             'payment_method' => 'cod',
                         ]);

        $response->assertRedirect(route('user.order.success', Order::first()))
                 ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'shop_id' => $product->shop_id,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $this->assertEquals($initialProductQuantity - 1, $product->fresh()->quantity);
    }

    /** @test */
    public function process_buy_now_fails_with_invalid_quantity()
    {
        $product = Product::find(1);
        $this->post(route('user.processBuyNow', $product->id), [
            'quantity' => 100, // More than available
            'user_name' => $this->faker->name,
            'user_email' => $this->faker->email,
            'user_phone' => $this->faker->phoneNumber,
            'shipping_address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'payment_method' => 'cod',
        ])->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_can_view_order_success_page()
    {
        $user = User::find(1);
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user)
             ->get(route('user.order.success', $order->id))
             ->assertOk()
             ->assertViewIs('user.order-success')
             ->assertViewHas('order', $order);
    }

    /** @test */
    public function unauthenticated_user_can_view_order_success_page()
    {
        $order = Order::factory()->create(['user_id' => null]); // Order by guest

        $this->get(route('user.order.success', $order->id))
             ->assertOk()
             ->assertViewIs('user.order-success')
             ->assertViewHas('order', $order);
    }

    /** @test */
    public function user_can_view_their_order_details()
    {
        $user = User::find(1);
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user)
             ->get(route('user.order.show', $order->id))
             ->assertOk()
             ->assertViewIs('user.order-details')
             ->assertViewHas('order', $order);
    }

    /** @test */
    public function authenticated_user_cannot_view_another_users_order_details()
    {
        $user = User::find(1);
        $anotherUser = User::factory()->create();
        $order = Order::factory()->for($anotherUser)->create();

        $this->actingAs($user)
             ->get(route('user.order.show', $order->id))
             ->assertStatus(403); // Unauthorized access
    }

    /** @test */
    public function unauthenticated_user_can_view_guest_order_details()
    {
        $order = Order::factory()->create(['user_id' => null]); // Order by guest

        $this->get(route('user.order.show', $order->id))
             ->assertOk()
             ->assertViewIs('user.order-details')
             ->assertViewHas('order', $order);
    }
}