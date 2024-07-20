<?php

namespace Feature\Admin;

use App\Http\Livewire\Admin\Catalog\Category\CategoryCreateController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryIndexController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryShowController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryTree;
use App\Models\Admin\Category;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class CategoryTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_category_listing_page()
    {
        $response = $this->get(
            route('admin.catalog.category.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_can_see_category_listing_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.catalog.category.index')
        );

        $response->assertOk();
    }

    public function test_authorized_users_cannot_create_category_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(CategoryCreateController::class)
            ->set('category.name', '')
            ->set('category.is_featured', '')
            ->call('store');

        $response->assertOk();
        $response->assertHasErrors([
            'category.name',
            'category.is_featured',
        ]);
    }

    public function test_authorized_users_can_create_category_with_valid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(CategoryCreateController::class)
            ->set('category.name', 'Test Category')
            ->set('category.is_featured', true)
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg'))
            ->call('store');

        $response->assertOk();
        $this->assertCount(1, Category::query()->featured()->get());
    }

    public function test_authorized_users_cannot_update_category_with_invalid_data()
    {
        $this->loginStaff(true);

        $category = Category::factory()->create()->first();

        $response = Livewire::test(CategoryShowController::class, [
            'category' => $category,
        ])
            ->set('category.name', '')
            ->set('category.is_featured', '')
            ->call('update');

        $response->assertOk();
        $response->assertHasErrors([
            'category.name',
            'category.is_featured',
        ]);
    }

    public function test_authorized_users_can_update_category_with_valid_data()
    {
        $this->loginStaff(true);

        $category = Category::factory()->create()->first();

        $response = Livewire::test(CategoryShowController::class, [
            'category' => $category,
        ])
            ->set('category.name', 'Test Category')
            ->set('category.is_featured', false)
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg'))
            ->call('update');

        $response->assertOk();
        $this->assertCount(1, Category::query()->where('name', 'Test Category')->where('is_featured', false)->get());
    }

    public function test_authorized_users_can_reorder_categories()
    {
        $this->loginStaff(true);

        $categories = Category::factory()->times(2)->create();

        $categories->each(function (Category $category, $key) {
            $category->setOrder($key);
        });

        $response = Livewire::test(CategoryIndexController::class)
            ->call('render');

        $response->assertOk();

        $tree = $response->tree;

        $categoryOne = $categories->get(0);
        $categoryTwo = $categories->get(1);

        $response = Livewire::test(
            CategoryTree::class,
            [
                'nodes' => $tree,
            ]
        )->call('sort', [
            'group' => 'root',
            'items' => [
                [
                    'id' => $categoryTwo->id,
                    'order' => $categoryOne->sort_order,
                    'parent' => null,
                ],
                [
                    'id' => $categoryOne->id,
                    'order' => $categoryTwo->sort_order,
                    'parent' => null,
                ],
            ],
        ]);

        $this->assertNotFalse(
            $categoryOne->refresh()->sort_order == 1
        );

        $this->assertNotFalse(
            $categoryTwo->refresh()->sort_order == 0
        );
    }
}
