<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Session::forget('cart'); // Clear cart before each test
    }

    /** @test */
    public function unauthenticated_user_cannot_view_cart()
    {
        $response = $this->get(route('user.cart'));
        $response->assertRedirect(route('user.login'));
    }

    /** @test */
    public function authenticated_user_can_view_empty_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.cart'));

        $response->assertStatus(200);
        $response->assertViewIs('user.cart');
        $response->assertViewHas('cartItems', []);
        $response->assertViewHas('cartTotal', 0);
        $response->assertViewHas('cartCount', 0);
    }

    /** @test */
    public function authenticated_user_can_view_cart_with_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['price' => 100]);
        Session::put('cart', [
            $product->id => [
                'quantity' => 2,
                'price' => 100,
                'original_price' => 100
            ]
        ]);

        $response = $this->get(route('user.cart'));

        $response->assertStatus(200);
        $response->assertViewIs('user.cart');
        $response->assertViewHas('cartItems');
        $this->assertCount(1, $response->viewData('cartItems'));
        $response->assertViewHas('cartTotal', 200);
        $response->assertViewHas('cartCount', 2);
    }

    /** @test */
    public function unauthenticated_user_cannot_clear_cart()
    {
        $response = $this->post(route('user.cart.clear'));
        $response->assertRedirect(route('user.login'));
    }

    /** @test */
    public function authenticated_user_can_clear_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        Session::put('cart', [
            $product->id => [
                'quantity' => 1,
                'price' => $product->price,
                'original_price' => $product->price
            ]
        ]);

        $response = $this->post(route('user.cart.clear'));

        $response->assertRedirect(route('user.cart'));
        $response->assertSessionHas('success', 'Cart cleared successfully!');
        $this->assertEmpty(Session::get('cart'));
    }

    /** @test */
    public function unauthenticated_user_cannot_remove_item_from_cart()
    {
        $product = Product::factory()->create();
        $response = $this->post(route('user.cart.remove', $product->id));
        $response->assertRedirect(route('user.login'));
    }

    /** @test */
    public function authenticated_user_can_remove_item_from_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        Session::put('cart', [
            $product->id => [
                'quantity' => 1,
                'price' => $product->price,
                'original_price' => $product->price
            ]
        ]);

        $response = $this->post(route('user.cart.remove', $product->id));

        $response->assertRedirect(route('user.cart'));
        $response->assertSessionHas('success', 'Product removed from cart!');
        $this->assertArrayNotHasKey($product->id, Session::get('cart'));
    }

    /** @test */
    public function removing_non_existent_product_from_cart_redirects_with_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('user.cart.remove', 999)); // Non-existent product ID

        $response->assertRedirect(route('user.cart'));
        $response->assertSessionHas('error', 'Product not found in cart!');
    }

    /** @test */
    public function unauthenticated_user_cannot_update_item_quantity()
    {
        $product = Product::factory()->create();
        $response = $this->post(route('user.cart.update-quantity', $product->id), ['quantity' => 3]);
        $response->assertRedirect(route('user.login'));
    }

    /** @test */
    public function authenticated_user_can_update_item_quantity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['price' => 50]);
        Session::put('cart', [
            $product->id => [
                'quantity' => 1,
                'price' => $product->price,
                'original_price' => $product->price
            ]
        ]);

        $response = $this->post(route('user.cart.update-quantity', $product->id), ['quantity' => 3]);

        $response->assertRedirect(route('user.cart'));
        $response->assertSessionHas('success', 'Cart updated successfully!');
        $this->assertEquals(3, Session::get('cart')[$product->id]['quantity']);
    }

    /** @test */
    public function updating_item_quantity_with_invalid_data_fails_validation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        Session::put('cart', [
            $product->id => [
                'quantity' => 1,
                'price' => $product->price,
                'original_price' => $product->price
            ]
        ]);

        $response = $this->post(route('user.cart.update-quantity', $product->id), ['quantity' => 0]);

        $response->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function updating_quantity_for_non_existent_product_redirects_with_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('user.cart.update-quantity', 999), ['quantity' => 2]); // Non-existent product ID

        $response->assertRedirect(route('user.cart'));
        $response->assertSessionHas('error', 'Product not found in cart!');
    }
}