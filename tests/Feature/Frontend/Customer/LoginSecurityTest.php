<?php

namespace Tests\Feature\Frontend\Customer;

use App\Http\Livewire\Frontend\Customer\LoginSecurity;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class LoginSecurityTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_customer_login_security_page()
    {
        $response = $this->get(route('customer.login.security'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authenticated_customers_can_access_login_security_page()
    {
        $this->loginUser();
        $response = $this->get(route('customer.login.security'));
        $response->assertOk();
    }

    public function test_guest_users_cannot_access_login_security_component()
    {
        Livewire::test(LoginSecurity::class)
            ->assertUnauthorized();
    }

    public function test_customer_login_security_required_fields_validations()
    {
        $this->loginUser();

        $response = Livewire::test(LoginSecurity::class);

        $response->set([
            'current_password' => '',
            'new_password' => '',
        ])->call('submit');

        $response->assertHasErrors([
            'current_password',
            'new_password',
        ]);
    }

    public function test_customer_cannot_update_its_login_security_info_with_invalid_data()
    {
        $this->loginUser();

        $response = Livewire::test(LoginSecurity::class);

        $response->set([
            'current_password' => 'passwrd',
            'new_password' => '12345678Hn',
            'confirm_password' => '12345678Hn',
        ])->call('submit');

        $response->assertHasErrors(['current_password']);
    }

    public function test_customer_can_update_its_login_security_info_with_valid_data()
    {
        $this->loginUser();

        $response = Livewire::test(LoginSecurity::class);

        $response->set([
            'current_password' => 'password',
            'new_password' => '12345678Hp',
            'confirm_password' => '12345678Hp',
        ])->call('submit');

        $response->assertEmitted('alert-success');
    }
}
