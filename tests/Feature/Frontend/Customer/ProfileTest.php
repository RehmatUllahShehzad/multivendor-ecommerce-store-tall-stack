<?php

namespace Tests\Feature\Frontend\Customer;

use App\Http\Livewire\Frontend\Customer\ProfileController;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class ProfileTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_customer_profile_page()
    {
        $response = $this->get(route('customer.profile'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authenticated_customers_can_access_profile_page()
    {
        $this->loginUser();
        $response = $this->get(route('customer.profile'));
        $response->assertOk();
    }

    public function test_guest_users_cannot_access_profile_component()
    {
        Livewire::test(ProfileController::class)
            ->assertUnauthorized();
    }

    public function test_customer_cannot_update_its_profile_with_invalid_date()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = Livewire::test(ProfileController::class)
            ->set('user.username', 'new-name')
            ->set('user.first_name', 'new')
            ->set('user.last_name', 'name')
            ->set('user.email', $user->email)
            ->call('submit');

        $response->assertStatus(200);
    }

    public function test_customer_can_update_its_profile()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = Livewire::test(ProfileController::class)
            ->set('user.username', 'new-name')
            ->set('user.first_name', 'new')
            ->set('user.last_name', 'name')
            ->set('user.email', $user->email)
            ->call('submit');

        $response->assertStatus(200);
    }
}
