<?php

namespace Tests\Feature\Frontend\Auth;

use App\Http\Livewire\Frontend\Auth\LoginController;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class LoginTest extends TestCase
{
    use WithLogin;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_users_can_login_with_valid_credentials(): void
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $response = Livewire::test(LoginController::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login');

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }

    public function test_users_can_not_login_with_invalid_credentials(): void
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $response = Livewire::test(LoginController::class)
            ->set('email', $user->email)
            ->set('password', 'wrongpassword')
            ->call('login');

        $response->assertStatus(200);
        $response->assertHasErrors('email');
        $this->assertGuest();
    }
}
