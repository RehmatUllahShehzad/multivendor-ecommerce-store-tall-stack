<?php

namespace Tests\Feature\Frontend\Auth;

use App\Http\Livewire\Frontend\Auth\VendorRegisterController;
use App\Models\Vendor;
use App\Models\VendorRequest;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class VendorRegisterationTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_vendor_registration_page()
    {
        $response = $this->get(route('register.vendor'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_vendors_redirect_to_vendor_dashbaord()
    {
        $this->loginUser(true);

        $response = $this->get(route('register'));

        $response->assertRedirect(
            route('vendor.dashboard')
        );
    }

    public function test_guest_users_cannot_fill_vendor_form()
    {
        Livewire::test(VendorRegisterController::class)
            ->assertUnauthorized();
    }

    public function test_vendor_can_register_with_invalid_data()
    {
        $this->loginUser();

        $response = Livewire::test(VendorRegisterController::class)
            ->set('vendor_name', '')
            ->set('company_name', '')
            ->set('bio', '')
            ->set('company_phone', '')
            ->set('company_address', '')
            ->call('register');

        $response->assertHasErrors([
            'vendor_name',
            'company_name',
            'company_phone',
            'bio',
            'company_address',
        ]);
    }

    public function test_vendor_can_register_with_valid_data()
    {
        $this->loginUser();

        $response = Livewire::test(VendorRegisterController::class)
            ->set('vendor_name', 'test')
            ->set('company_name', 'dot logics')
            ->set('bio', 'asda ')
            ->set('company_phone', '+1 (555) 555-1234')
            ->set('company_address', 'foo')
            ->call('register');

        $response->assertOk();
        $this->count(1, VendorRequest::query()->approved()->get());
        $this->count(1, Vendor::query()->where('vendor_name', 'test')->get());
    }
}
