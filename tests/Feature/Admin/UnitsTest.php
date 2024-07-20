<?php

namespace Feature\Admin;

use App\Http\Livewire\Admin\System\Unit\UnitCreateController;
use App\Http\Livewire\Admin\System\Unit\UnitIndexController;
use App\Http\Livewire\Admin\System\Unit\UnitShowController;
use App\Models\Admin\Unit;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class UnitsTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_units_listing()
    {
        $response = $this->get(
            route('admin.system.unit.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_can_see_units_listing()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.system.unit.index')
        );

        $response->assertOk();
    }

    public function test_authorized_users_cannot_create_units_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(UnitCreateController::class)
            ->set('unit.name', '')
            ->call('create');

        $response->assertOk();

        $response->assertHasErrors([
            'unit.name',
        ]);
    }

    public function test_authorized_users_can_create_units_with_valid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(UnitCreateController::class)
            ->set('unit.name', 'test name')
            ->call('create');

        $response->assertOk();

        $this->assertCount(1, Unit::all());
    }

    public function test_authorized_users_cannot_update_units_with_invalid_data()
    {
        $this->loginStaff(true);

        $unit = Unit::factory()->create()->first();

        $response = Livewire::test(UnitShowController::class, [
            'unit' => $unit,
        ])
            ->set('unit.name', '')
            ->call('update');

        $response->assertOk();

        $response->assertHasErrors([
            'unit.name',
        ]);
    }

    public function test_authorized_users_can_update_units_with_valid_data()
    {
        $this->loginStaff(true);

        $unit = Unit::factory()->create()->first();

        $response = Livewire::test(UnitShowController::class, [
            'unit' => $unit,
        ])
            ->set('unit.name', 'test name')
            ->call('update');

        $response->assertOk();

        $this->assertCount(1, Unit::all());
    }

    public function test_authorized_users_can_search_units()
    {
        $this->loginStaff(true);

        $units = Unit::factory()->count(5)->create();

        $response = Livewire::test(UnitIndexController::class)
            ->set('search', $units->get(1)->name);

        $response->assertSee($units->get(1)->name);
        $response->assertDontSee($units->get(2)->name);

        $response = Livewire::test(UnitIndexController::class)
            ->set('search', 'invalid records');

        $response->assertSee(
            __('notifications.search-results.none')
        );
    }

    public function test_authorized_users_can_see_deleted_units()
    {
        $this->loginStaff(true);

        $units = Unit::factory()->count(5)->create();

        $units->get(3)->delete();

        $response = Livewire::test(UnitIndexController::class)
            ->set('showTrashed', false);

        $response->assertDontSee($units->get(3)->name);

        $response = Livewire::test(UnitIndexController::class)
            ->set('showTrashed', true);

        $response->assertSee($units->get(3)->name);
    }
}
