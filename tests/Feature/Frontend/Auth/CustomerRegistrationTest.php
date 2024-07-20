<?php

namespace Tests\Feature\Frontend\Auth;

use App\Http\Livewire\Frontend\Auth\RegisterController;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class CustomerRegistrationTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_can_see_registration_screen(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_authenticated_users_cannot_see_registration_screen(): void
    {
        $this->loginUser();

        $response = $this->get(route('register'));

        $response->assertRedirect(
            route('customer.dashboard')
        );
    }

    public function test_authenticated_customers_redirect_to_customer_dashbaord_from_registration_link()
    {
        $this->loginUser();

        $response = $this->get(route('register'));

        $response->assertRedirect(
            route('customer.dashboard')
        );
    }

    public function test_guest_users_cannot_register_with_invalid_data(): void
    {
        $response = Livewire::test(RegisterController::class)
            ->set('user.first_name', '')
            ->set('user.last_name', '')
            ->set('user.email', '')
            ->set('password', '')
            ->set('confirmPassword', 'password')
            ->call('register');

        $response->assertStatus(200);
        $response->assertHasErrors([
            'user.first_name',
            'user.last_name',
            'user.email',
            'password',
        ]);
    }

    public function test_guest_users_can_register_with_valid_data(): void
    {
        $response = Livewire::test(RegisterController::class)
            ->set('user.first_name', 'Test')
            ->set('user.last_name', 'User')
            ->set('user.email', 'test@example.com')
            ->set('password', 'password')
            ->set('confirmPassword', 'password')
            ->call('register');

        $response->assertStatus(200);
    }
}
