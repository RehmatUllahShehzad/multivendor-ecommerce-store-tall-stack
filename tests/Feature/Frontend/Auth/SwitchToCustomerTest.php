<?php

namespace Tests\Feature\Frontend\Auth;

use App\Http\Livewire\Frontend\Auth\LoginController;
use App\Http\Livewire\Frontend\Auth\VendorRegisterController;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SwitchToCustomerTest extends TestCase
{
    public function test_switch_to_customer_button_exist_in_view_after_vendor_register()
    {
        $user = User::factory()->create();

        $response = Livewire::test(LoginController::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login');

        $response = Livewire::test(VendorRegisterController::class)
            ->set('vendor_name', 'james')
            ->set('company_name', 'dot logics')
            ->set('bio', 'asda ')
            ->set('company_phone', '+1 (555) 555-1234')
            ->set('company_address', 'foo')
            ->call('register');

        $response->assertRedirect(route('customer.dashboard'));

        $this->get(route('customer.dashboard'));

    }
}
