<?php

namespace Feature\Admin;

use App\Http\Livewire\Admin\Profile\StaffProfileController;
use App\Models\Admin\Staff;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class ProfileTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_profile_page()
    {
        $response = $this->get(
            route('admin.staff.profile')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_cannot_update_profile_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.staff.profile')
        );

        $response->assertOk();

        $response = Livewire::test(
            StaffProfileController::class
        )
            ->set('staff.email', '')
            ->set('staff.first_name', '')
            ->set('staff.last_name', '')
            ->set('password', '123456788')
            ->set('currentPassword', '')
            ->call('update');

        $response->assertOk();
        $response->assertHasErrors([
            'staff.email',
            'staff.first_name',
            'staff.last_name',
            'currentPassword',
        ]);
    }

    public function test_authorized_users_can_see_and_update_profile()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.staff.profile')
        );

        $response->assertOk();

        $response = Livewire::test(
            StaffProfileController::class
        )
            ->set('staff.email', 'test@email.com')
            ->set('staff.first_name', 'test first')
            ->set('staff.last_name', 'test last')
            ->set('password', '123456788')
            ->set('currentPassword', 'password')
            ->call('update');

        $response->assertOk();
        $response->assertDispatchedBrowserEvent('notify');

        $this->assertNotFalse(
            'test first' == Staff::query()->first()->first_name
        );
    }
}
