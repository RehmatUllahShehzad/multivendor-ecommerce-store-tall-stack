<?php

namespace Tests\Feature\Admin;

use App\Http\Livewire\Admin\Auth\LoginController;
use App\Http\Livewire\Admin\System\Staff\StaffCreateController;
use App\Http\Livewire\Admin\System\Staff\StaffIndexController;
use App\Http\Livewire\Admin\System\Staff\StaffShowController;
use App\Models\Admin\Staff;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class StaffTest extends TestCase
{
    use WithLogin;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
    }

    public function test__staff_can_login_with_valid_credentials(): void
    {
        $staff = Staff::factory()->admin()->create();

        $response = Livewire::test(LoginController::class)
            ->set('email', $staff->email)
            ->set('password', 'password')
            ->call('login');

        $response->assertStatus(200);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_authorized_staff_can_see_staff_listing_page(): void
    {
        $staff = $this->loginStaff();

        $response = $this->get(route('admin.system.staff.index'));

        $response->assertOk();

        $response->assertSee($staff->email);
    }

    public function test_authorized_staff_can_see_deleted_staff_list(): void
    {
        $this->loginStaff();

        $deletedStaff = Staff::factory()->deleted()->create();

        $response = Livewire::test(StaffIndexController::class)
            ->set('showTrashed', true)
            ->call('render');

        $response->assertOk();

        $response->assertSee($deletedStaff->email);
    }

    public function test_admin_user_can_search_staff_by_first_name_last_name_and_email_on_staff_listing_page(): void
    {
        $admin = $this->loginStaff();

        $staffList = Staff::factory()->times(10)->create();

        $randomStaff = $staffList->random();

        /** Test Search By email */
        $response = Livewire::test(StaffIndexController::class)
            ->set('search', $randomStaff->email)
            ->call('render');

        $response->assertOk();
        $response->assertSee($randomStaff->email);

        /** Test Search by first name */
        $response = Livewire::test(StaffIndexController::class)
            ->set('search', $randomStaff->first_name)
            ->call('render');

        $response->assertOk();
        $response->assertSee($randomStaff->first_name);

        /** Test Search by last name */
        $response = Livewire::test(StaffIndexController::class)
            ->set('search', $randomStaff->last_name)
            ->call('render');

        $response->assertOk();
        $response->assertSee($randomStaff->last_name);

        /** Test Search by invalid keyword */
        $response = Livewire::test(StaffIndexController::class)
            ->set('search', 'testnorecordfound')
            ->call('render');

        $response->assertOk();
        $response->assertSee(
            __('notifications.search-results.none')
        );
    }

    public function test_unauthenticated_users_cannot_access_create_staff_form(): void
    {
        $response = $this->get(route('admin.system.staff.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_authorized_staff_cannot_add_staff_with_invalid_data(): void
    {
        $this->loginStaff();

        $response = Livewire::test(StaffCreateController::class)
            ->set('isAdmin', true)
            ->set('password', '12345678')
            ->call('create');

        $response->assertHasErrors([
            'staff.email',
            'staff.first_name',
            'staff.last_name',
        ]);
    }

    public function test_authorized_staff_can_add_staff_with_valid_data(): void
    {
        $this->loginStaff();

        $response = Livewire::test(StaffCreateController::class)
            ->set('staff.email', 'staff@staff.com')
            ->set('staff.first_name', 'saa')
            ->set('staff.last_name', 'staff')
            ->set('password', '12345678')
            ->set('password_confirmation', '12345678')
            ->set('staffPermissions', collect(['system', 'system:settings']))
            ->call('create');

        $response->assertOk();
        $this->assertCount(1, Staff::where('email', 'staff@staff.com')->get());
    }

    public function test_authorized_staff_can_see_detail_of_any_staff()
    {
        $this->loginStaff();

        $staff = Staff::factory()->create()->first();

        $response = $this->get(route('admin.system.staff.show', $staff));

        $response->assertOk();
        $response->assertSee($staff->first_name);
        $response->assertSee($staff->last_name);
        $response->assertSee($staff->email);
    }

    public function test_authorized_staff_cannot_update_staff_with_invalid_data(): void
    {
        $this->loginStaff();

        $staff = Staff::factory()->create();

        $response = Livewire::test(StaffShowController::class, [
            'staff' => $staff,
        ])
            ->set('staff.email', '')
            ->set('staff.first_name', '')
            ->set('staff.last_name', '')
            ->call('update');

        $response->assertOk();
        $response->assertHasErrors([
            'staff.email',
            'staff.first_name',
            'staff.last_name',
        ]);
    }

    public function test_authorized_staff_can_update_staff_with_valid_data(): void
    {
        $this->loginStaff();

        $staff = Staff::factory()->create();

        $response = Livewire::test(StaffShowController::class, [
            'staff' => $staff,
        ])
            ->set('staff.email', 'updated@email.com')
            ->set('staff.first_name', 'test')
            ->set('staff.last_name', 'updated')
            ->call('update');

        $response->assertOk();

        $this->assertCount(
            1,
            Staff::query()->where('email', 'updated@email.com')->get()
        );

        $this->assertCount(
            1,
            Staff::query()->where('first_name', 'test')->get()
        );

        $this->assertCount(
            1,
            Staff::query()->where('last_name', 'updated')->get()
        );
    }

    public function test_authorized_staff_can_delete_staff(): void
    {
        $this->loginStaff();

        $staff = Staff::factory()->create();

        $response = Livewire::test(StaffShowController::class, [
            'staff' => $staff,
        ])
            ->call('delete');

        $response->assertOk();
        $this->assertCount(0, Staff::whereEmail('staff@staff.com')->get());
    }
}
