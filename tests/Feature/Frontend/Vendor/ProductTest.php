<?php

namespace Tests\Feature\Frontend\Vendor;

use App\Http\Livewire\Frontend\Vendor\Product\ProductCreateController;
use App\Http\Livewire\Frontend\Vendor\Product\ProductEditController;
use App\Http\Livewire\Frontend\Vendor\Product\ProductIndexController;
use App\Models\Admin\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class ProductTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_vendor_product_listing_page()
    {
        $response = $this->get(route('vendor.product.index'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authorized_user_can_access_vendor_product_listing_page()
    {
        $this->loginUser(true);
        $response = $this->get(route('vendor.product.index'));
        $response->assertOk();
    }

    public function test_authorized_vendor_can_view_all_of_his_products()
    {
        $product = User::factory()
            ->count(1)
            ->has(
                Product::factory(10)
                    ->has(Category::factory(1))
            )
            ->has(
                Vendor::factory(1)
            )
            ->create()
            ->first();

        $response = Livewire::actingAs($product)
            ->test(ProductIndexController::class)
            ->call('render');

        $response->assertSee($product->title)
            ->assertOk();
    }

    public function test_vendor_can_sort_product_record(): void
    {
        $user = User::factory()
            ->count(1)
            ->has(
                Product::factory(10)
                    ->has(Category::factory(1))
            )
            ->has(
                Vendor::factory(1)
            )
            ->create()
            ->first();

        $product = Product::all();

        /** Test Sort By Newest order */
        $response = Livewire::actingAs($user)
            ->test(ProductIndexController::class)
            ->set('sortBy', 'newest')
            ->call('render');

        $response->assertSeeInOrder([
            $product[0]['09/30/22'],
            $product[1]['09/28/22'],
            $product[2]['09/26/22'],
        ]);

        /** Test Sort By Date order */
        $response = Livewire::actingAs($user)
            ->test(ProductIndexController::class)
            ->set('sortBy', 'date')
            ->call('render');

        $response->assertSeeInOrder([
            $product[0]['09/26/22'],
            $product[1]['09/28/22'],
            $product[2]['09/30/22'],
        ]);

        ///** Test Sort By ascending title order */
        $response = Livewire::actingAs($user)
            ->test(ProductIndexController::class)
            ->set('sortBy', 'asc')
            ->call('render');

        $response->assertSeeInOrder([
            $product[2]['abc'],
            $product[0]['def'],
            $product[6]['ghi'],
        ]);

        /** Test Sort By descending title order */
        $response = Livewire::test(ProductIndexController::class)
            ->set('sortBy', 'desc')
            ->call('render');

        $response->assertSeeInOrder([
            $product[6]['ghi'],
            $product[0]['def'],
            $product[2]['abc'],
        ]);

        /** Test Sort By publish order */
        $response = Livewire::test(ProductIndexController::class)
            ->set('sortBy', 'publish')
            ->call('render');

        $response->assertSeeInOrder([
            $product[6][1],
            $product[0][1],
        ]);

        /** Test Sort By un-publish order */
        $response = Livewire::test(ProductIndexController::class)
            ->set('sortBy', 'un_publish')
            ->call('render');

        $response->assertSeeInOrder([
            $product[6][0],
        ]);
    }

    public function test_vendor_can_search_product_by_name()
    {
        $user = User::factory()
            ->count(1)
            ->has(
                Product::factory(5)
                    ->has(Category::factory(1))
            )
            ->has(
                Vendor::factory(1)
            )
            ->create()
            ->first();

        $product = Product::all();

        $response = Livewire::actingAs($user)
            ->test(ProductIndexController::class)
            ->set('search', $product->get(1)->title)
            ->set('dateRange', [
                $product->get(1)->created_at,
                $product->get(1)->created_at,
            ]);

        $response->assertSee($product->get(1)->title);

        $response->assertDontSee($product->get(2)->title);

        $response = Livewire::actingAs($user)
            ->test(ProductIndexController::class)
            ->set('search', 'invalid records');

        $response->assertSee(
            __('global.no_records')
        );
    }

    public function test_guest_user_cannot_access_vendor_create_product_page()
    {
        $response = $this->get(route('vendor.product.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_authorized_vendor_cannot_create_a_new_product_with_invalid_data()
    {
        $this->loginUser();

        $response = Livewire::test(ProductCreateController::class)
            ->set('images', [])
            ->set('nutritionInputs.*.nutrition_id', '')
            ->set('nutritionInputs.*.unit_id', '')
            ->set('nutritionInputs.*.value', '')
            ->set('product.title', '')
            ->set('product.description', '')
            ->set('product.available_quantity', '')
            ->set('product.unit_id', '')
            ->set('product.price', '')
            ->call('submit');

        $response->assertHasErrors([
            'images',
            'nutritionInputs.*.nutrition_id',
            'nutritionInputs.*.unit_id',
            'nutritionInputs.*.value',
            'product.title',
            'product.description',
            'product.available_quantity',
            'product.unit_id',
            'product.price',
        ]);
    }

    public function test_authorized_vendor_can_create_a_new_product_with_valid_data()
    {
        $this->loginUser();

        $response = Livewire::test(ProductCreateController::class)
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg'))
            ->set('selectedCategories', [1, 3])
            ->set('nutritionInputs.0.nutrition_id', 1)
            ->set('nutritionInputs.0.unit_id', 2)
            ->set('nutritionInputs.0.value', 3)
            ->set('product.title', 'Cupcake')
            ->set('product.description', 'Lorem ipsum description')
            ->set('product.available_quantity', 40)
            ->set('product.unit_id', 3)
            ->set('product.price', 50.00)
            ->set('product.attributes', 'Neque qui at excepte.')
            ->set('product.ingredients', 'Labore deleniti et s.')
            ->set('product.is_published', 1)
            ->call('submit');

        $response->assertHasNoErrors()
            ->assertStatus(200);

        $this->assertCount(1, Product::where('title', 'Cupcake')->get());
    }

    public function test_authorized_vendor_cannot_update_product_with_invalid_data()
    {
        $user = User::factory()
            ->count(1)
            ->has(
                Product::factory(10)
                    ->has(Category::factory(1))
            )
            ->has(
                Vendor::factory(1)
            )
            ->create()
            ->first();

        $product = Product::first();

        $response = Livewire::actingAs($user)
            ->test(ProductEditController::class, [
                'product' => $product,
            ])
            ->set('images', [])
            ->set('nutritionInputs.0.nutrition_id', '')
            ->set('nutritionInputs.0.unit_id', '')
            ->set('nutritionInputs.0.value', '')
            ->set('product.title', '')
            ->set('product.description', '')
            ->set('product.available_quantity', '')
            ->set('product.unit_id', '')
            ->set('product.price', '')
            ->call('update');

        $response->assertOk();
        $response->assertHasErrors([
            'images',
            'nutritionInputs.*.nutrition_id',
            'nutritionInputs.*.unit_id',
            'nutritionInputs.*.value',
            'product.title',
            'product.description',
            'product.available_quantity',
            'product.unit_id',
            'product.price',
        ]);
    }

    public function test_authorized_vendor_can_update_product_with_valid_data()
    {
        $user = User::factory()
            ->count(1)
            ->has(
                Product::factory(10)
                    ->has(Category::factory(1))
            )
            ->has(
                Vendor::factory(1)
            )
            ->create()
            ->first();

        $product = Product::first();

        $response = Livewire::actingAs($user)
            ->test(ProductEditController::class, [
                'product' => $product,
            ])
            ->set('product.title', 'Cupcake updated')
            ->set('product.description', 'Lorem ipsum updated')
            ->set('product.available_quantity', 10)
            ->set('product.is_gluten_free', 1)
            ->set('product.is_vegan', null)
            ->set('product.is_published', 1)
            ->call('update');

        $response->assertOk();

        $this->assertCount(
            1,
            Product::query()->where('title', 'Cupcake updated')->get()
        );
    }
}
