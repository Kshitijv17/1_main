<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create some categories, shops, and products for testing
        Category::factory()->create(['id' => 1, 'title' => 'Category A', 'sort_order' => 1]);
        Category::factory()->create(['id' => 2, 'title' => 'Category B', 'sort_order' => 2]);
        Shop::factory()->create(['id' => 1, 'name' => 'Shop X', 'is_active' => true]);
        Shop::factory()->create(['id' => 2, 'name' => 'Shop Y', 'is_active' => true]);
        Shop::factory()->create(['id' => 3, 'name' => 'Inactive Shop Z', 'is_active' => false]);

        Product::factory()->create(['id' => 1, 'title' => 'Product 1', 'description' => 'Description 1', 'price' => 100, 'category_id' => 1, 'shop_id' => 1, 'is_active' => true, 'is_featured' => true, 'created_at' => now()->subDays(5)]);
        Product::factory()->create(['id' => 2, 'title' => 'Product 2', 'description' => 'Description 2', 'price' => 200, 'category_id' => 1, 'shop_id' => 1, 'is_active' => true, 'is_featured' => false, 'created_at' => now()->subDays(3)]);
        Product::factory()->create(['id' => 3, 'title' => 'Product 3', 'description' => 'Description 3', 'price' => 150, 'category_id' => 2, 'shop_id' => 2, 'is_active' => true, 'is_featured' => true, 'created_at' => now()->subDays(1)]);
        Product::factory()->create(['id' => 4, 'title' => 'Inactive Product 4', 'description' => 'Description 4', 'price' => 50, 'category_id' => 2, 'shop_id' => 2, 'is_active' => false, 'is_featured' => false]);
        Product::factory()->create(['id' => 5, 'title' => 'Product 5 from Inactive Shop', 'description' => 'Description 5', 'price' => 250, 'category_id' => 1, 'shop_id' => 3, 'is_active' => true, 'is_featured' => false]);
    }

    /** @test */
    public function it_displays_the_homepage_with_products_and_filters()
    {
        $this->get(route('user.home'))
             ->assertOk()
             ->assertViewIs('user.home')
             ->assertViewHas('products')
             ->assertViewHas('categories')
             ->assertViewHas('shops')
             ->assertViewHas('featuredProducts')
             ->assertViewHas('stats');

        $response = $this->get(route('user.home'));
        $products = $response->original->getData()['products'];
        $this->assertCount(3, $products); // Only active products from active shops
    }

    /** @test */
    public function it_can_search_products_on_homepage()
    {
        $this->get(route('user.home', ['search' => 'Product 1']))
             ->assertOk()
             ->assertSee('Product 1')
             ->assertDontSee('Product 2');
    }

    /** @test */
    public function it_can_filter_products_by_category_on_homepage()
    {
        $this->get(route('user.home', ['category' => 1]))
             ->assertOk()
             ->assertSee('Product 1')
             ->assertSee('Product 2')
             ->assertDontSee('Product 3');
    }

    /** @test */
    public function it_can_filter_products_by_shop_on_homepage()
    {
        $this->get(route('user.home', ['shop' => 2]))
             ->assertOk()
             ->assertSee('Product 3')
             ->assertDontSee('Product 1');
    }

    /** @test */
    public function it_can_filter_products_by_price_range_on_homepage()
    {
        $this->get(route('user.home', ['min_price' => 120, 'max_price' => 180]))
             ->assertOk()
             ->assertSee('Product 3')
             ->assertDontSee('Product 1')
             ->assertDontSee('Product 2');
    }

    /** @test */
    public function it_can_sort_products_by_price_low_on_homepage()
    {
        $response = $this->get(route('user.home', ['sort' => 'price_low']));
        $products = $response->original->getData()['products'];
        $this->assertEquals('Product 1', $products->first()->title); // Price 100
    }

    /** @test */
    public function it_can_sort_products_by_price_high_on_homepage()
    {
        $response = $this->get(route('user.home', ['sort' => 'price_high']));
        $products = $response->original->getData()['products'];
        $this->assertEquals('Product 2', $products->first()->title); // Price 200
    }

    /** @test */
    public function it_can_sort_products_by_name_on_homepage()
    {
        $response = $this->get(route('user.home', ['sort' => 'name']));
        $products = $response->original->getData()['products'];
        $this->assertEquals('Product 1', $products->first()->title); // Alphabetical
    }

    /** @test */
    public function it_can_sort_products_by_featured_on_homepage()
    {
        $response = $this->get(route('user.home', ['sort' => 'featured']));
        $products = $response->original->getData()['products'];
        $this->assertEquals('Product 3', $products->first()->title); // Featured and latest created_at
    }

    /** @test */
    public function it_displays_category_page_with_products()
    {
        $category = Category::find(1);
        $this->get(route('user.category', $category->id))
             ->assertOk()
             ->assertViewIs('user.category')
             ->assertViewHas('category', $category)
             ->assertViewHas('products');

        $response = $this->get(route('user.category', $category->id));
        $products = $response->original->getData()['products'];
        $this->assertCount(2, $products); // Product 1, Product 2
    }

    /** @test */
    public function it_can_search_products_within_category_page()
    {
        $category = Category::find(1);
        $this->get(route('user.category', [$category->id, 'search' => 'Product 1']))
             ->assertOk()
             ->assertSee('Product 1')
             ->assertDontSee('Product 3');
    }

    /** @test */
    public function it_displays_shop_page_with_products()
    {
        $shop = Shop::find(1);
        $this->get(route('user.shop', $shop->id))
             ->assertOk()
             ->assertViewIs('user.shop')
             ->assertViewHas('shop', $shop)
             ->assertViewHas('products')
             ->assertViewHas('categories');

        $response = $this->get(route('user.shop', $shop->id));
        $products = $response->original->getData()['products'];
        $this->assertCount(2, $products); // Product 1, Product 2
    }

    /** @test */
    public function it_returns_404_for_inactive_shop_page()
    {
        $inactiveShop = Shop::find(3);
        $this->get(route('user.shop', $inactiveShop->id))
             ->assertStatus(404);
    }

    /** @test */
    public function it_can_search_products_within_shop_page()
    {
        $shop = Shop::find(1);
        $this->get(route('user.shop', [$shop->id, 'search' => 'Product 1']))
             ->assertOk()
             ->assertSee('Product 1')
             ->assertDontSee('Product 3');
    }

    /** @test */
    public function it_can_filter_products_by_category_within_shop_page()
    {
        $shop = Shop::find(1);
        $category = Category::find(1);
        $this->get(route('user.shop', [$shop->id, 'category' => $category->id]))
             ->assertOk()
             ->assertSee('Product 1')
             ->assertSee('Product 2')
             ->assertDontSee('Product 3');
    }

    /** @test */
    public function it_returns_json_for_ajax_search()
    {
        $this->get(route('user.ajaxSearch', ['search' => 'Product']))
             ->assertOk()
             ->assertJsonStructure([
                 'status',
                 'data' => [
                     '*' => [
                         'id',
                         'title',
                         'slug',
                         'image',
                         'price',
                         'selling_price',
                     ]
                 ]
             ])
             ->assertJsonFragment(['title' => 'Product 1']);
    }

    /** @test */
    public function ajax_search_can_filter_by_category()
    {
        $this->get(route('user.ajaxSearch', ['category' => 2]))
             ->assertOk()
             ->assertJsonFragment(['title' => 'Product 3'])
             ->assertJsonMissing(['title' => 'Product 1']);
    }
}