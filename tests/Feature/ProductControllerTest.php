<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create some categories, shops, and products for testing
        Category::factory()->create(['id' => 1, 'title' => 'Category A']);
        Category::factory()->create(['id' => 2, 'title' => 'Category B']);
        Shop::factory()->create(['id' => 1, 'name' => 'Shop X', 'is_active' => true]);
        Shop::factory()->create(['id' => 2, 'name' => 'Shop Y', 'is_active' => false]); // Inactive shop

        Product::factory()->create(['id' => 1, 'title' => 'Active Product', 'category_id' => 1, 'shop_id' => 1, 'is_active' => true, 'discount_price' => 80, 'price' => 100]);
        Product::factory()->create(['id' => 2, 'title' => 'Inactive Product', 'category_id' => 1, 'shop_id' => 1, 'is_active' => false]);
        Product::factory()->create(['id' => 3, 'title' => 'Product from Inactive Shop', 'category_id' => 1, 'shop_id' => 2, 'is_active' => true]);
        Product::factory()->create(['id' => 4, 'title' => 'Related Product 1', 'category_id' => 1, 'shop_id' => 1, 'is_active' => true]);
        Product::factory()->create(['id' => 5, 'title' => 'Related Product 2', 'category_id' => 1, 'shop_id' => 1, 'is_active' => true]);
        Product::factory()->create(['id' => 6, 'title' => 'Shop Product 1', 'category_id' => 2, 'shop_id' => 1, 'is_active' => true]);
        Product::factory()->create(['id' => 7, 'title' => 'Shop Product 2', 'category_id' => 2, 'shop_id' => 1, 'is_active' => true]);
    }

    /** @test */
    public function it_displays_an_active_product_page()
    {
        $product = Product::find(1);
        $this->get(route('user.product.show', $product->id))
             ->assertOk()
             ->assertViewIs('user.product')
             ->assertViewHas('product', $product)
             ->assertViewHas('relatedProducts')
             ->assertViewHas('shopProducts')
             ->assertViewHas('discountPercentage', 20.0)
             ->assertViewHas('finalPrice', 80);
    }

    /** @test */
    public function it_returns_404_for_inactive_product()
    {
        $product = Product::find(2);
        $this->get(route('user.product.show', $product->id))
             ->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_for_product_from_inactive_shop()
    {
        $product = Product::find(3);
        $this->get(route('user.product.show', $product->id))
             ->assertStatus(404);
    }

    /** @test */
    public function it_returns_json_for_product_search()
    {
        $this->get(route('user.product.search', ['q' => 'Active Product']))
             ->assertOk()
             ->assertJsonStructure([
                 '*' => [
                     'id',
                     'name',
                     'price',
                     'discount_price',
                     'image',
                     'shop_name',
                     'category_name',
                     'url',
                 ]
             ])
             ->assertJsonFragment(['name' => 'Active Product']);
    }

    /** @test */
    public function product_search_requires_minimum_query_length()
    {
        $this->get(route('user.product.search', ['q' => 'a']))
             ->assertOk()
             ->assertJson([]);
    }

    /** @test */
    public function product_search_filters_by_active_products_and_shops()
    {
        $this->get(route('user.product.search', ['q' => 'Product']))
             ->assertOk()
             ->assertJsonMissing(['name' => 'Inactive Product'])
             ->assertJsonMissing(['name' => 'Product from Inactive Shop']);
    }
}