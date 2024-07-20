<?php

namespace Feature\Admin;

use App\Http\Livewire\Admin\Catalog\Nutrition\NutritionCreateController;
use App\Http\Livewire\Admin\Catalog\Nutrition\NutritionIndexController;
use App\Http\Livewire\Admin\Catalog\Nutrition\NutritionShowController;
use App\Models\Admin\Nutrition;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class NutritionTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_nutrition_listing()
    {
        $response = $this->get(
            route('admin.catalog.nutrition.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_can_see_nutritions_listing()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.catalog.nutrition.index')
        );

        $response->assertOk();
    }

    public function test_authorized_users_cannot_create_nutrition_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(NutritionCreateController::class)
            ->set('nutrition.name', '')
            ->call('create');

        $response->assertOk();

        $response->assertHasErrors([
            'nutrition.name',
        ]);
    }

    public function test_authorized_users_can_create_nutrition_with_valid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(NutritionCreateController::class)
            ->set('nutrition.name', 'test name')
            ->call('create');

        $response->assertOk();

        $this->assertCount(1, Nutrition::all());
    }

    public function test_authorized_users_cannot_update_nutrition_with_invalid_data()
    {
        $this->loginStaff(true);

        $nutrition = Nutrition::factory()->create()->first();

        $response = Livewire::test(NutritionShowController::class, [
            'nutrition' => $nutrition,
        ])
            ->set('nutrition.name', '')
            ->call('update');

        $response->assertOk();

        $response->assertHasErrors([
            'nutrition.name',
        ]);
    }

    public function test_authorized_users_can_update_nutrition_with_valid_data()
    {
        $this->loginStaff(true);

        $nutrition = Nutrition::factory()->create()->first();

        $response = Livewire::test(NutritionShowController::class, [
            'nutrition' => $nutrition,
        ])
            ->set('nutrition.name', 'test name')
            ->call('update');

        $response->assertOk();

        $this->assertCount(1, Nutrition::all());
    }

    public function test_authorized_users_can_search_nutritions()
    {
        $this->loginStaff(true);

        $nutritions = Nutrition::factory()->count(5)->create();

        $response = Livewire::test(NutritionIndexController::class)
            ->set('search', $nutritions->get(1)->name);

        $response->assertSee($nutritions->get(1)->name);
        $response->assertDontSee($nutritions->get(2)->name);

        $response = Livewire::test(NutritionIndexController::class)
            ->set('search', 'invalid records');

        $response->assertSee(
            __('notifications.search-results.none')
        );
    }

    public function test_authorized_users_can_see_deleted_nutritions()
    {
        $this->loginStaff(true);

        $nutritions = Nutrition::factory()->count(5)->create();

        $nutritions->get(3)->delete();

        $response = Livewire::test(NutritionIndexController::class)
            ->set('showTrashed', false);

        $response->assertDontSee($nutritions->get(3)->name);

        $response = Livewire::test(NutritionIndexController::class)
            ->set('showTrashed', true);

        $response->assertSee($nutritions->get(3)->name);
    }
}
