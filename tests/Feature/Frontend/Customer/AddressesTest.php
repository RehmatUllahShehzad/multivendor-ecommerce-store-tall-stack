<?php

namespace Tests\Feature\Frontend\Customer;

use App\Enums\AddressType;
use App\Http\Livewire\Frontend\Customer\Addresses\AddressIndexController;
use App\Http\Livewire\Frontend\Customer\Addresses\AddressShowController;
use App\Http\Livewire\Frontend\Customer\Addresses\CreateAddressController;
use App\Models\Address;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class AddressesTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_customer_address_listing_page()
    {
        $response = $this->get(route('customer.addresses.index'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authorized_customers_can_access_address_listing_page()
    {
        $this->loginUser();
        $response = $this->get(route('customer.addresses.index'));
        $response->assertOk();
    }

    public function test_guest_user_cannot_access_customer_create_address_page()
    {
        $response = $this->get(route('customer.addresses.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_authorized_customers_cannot_create_a_new_address_with_invalid_data()
    {
        $this->loginUser();

        $response = Livewire::test(CreateAddressController::class)
            ->set('address.first_name', '')
            ->set('address.last_name', '')
            ->set('address.phone', '')
            ->set('address.address_1', '')
            ->set('address.address_2', '')
            ->set('address.city', '')
            ->set('address.state_id', '')
            ->set('address.zip', '')
            ->set('isPrimary', '')
            ->call('submit');

        $response->assertHasErrors([
            'address.first_name',
            'address.last_name',
            'address.address_1',
            'address.city',
            'address.state_id',
            'address.zip',
        ]);
    }

    public function test_authorized_customers_can_create_a_new_address_with_valid_data()
    {
        $this->loginUser();

        $response = Livewire::test(CreateAddressController::class)
            ->set('address.first_name', 'test1')
            ->set('address.last_name', 'test2')
            ->set('address.phone', '12345678911')
            ->set('address.address_1', 'test')
            ->set('address.city', 'test')
            ->set('address.state_id', '1478')
            ->set('address.zip', '123')
            ->set('isPrimary', true)
            ->set('address.address_type', AddressType::Work)
            ->call('submit');
        $response->assertHasNoErrors()
            ->assertStatus(200);

        $this->assertCount(1, Address::where('first_name', 'test1')->get());
    }

    public function test_authorized_customers_can_view_all_of_his_addresses()
    {
        $address = Address::factory()
            ->count(1)
            ->for(State::factory()->for(Country::factory()))
            ->for(User::factory())
            ->create()
            ->first();

        $response = Livewire::actingAs($address->user)
            ->test(AddressIndexController::class)
            ->call('render');

        $response->assertSee($address->first_name)
            ->assertOk();
    }

    public function test_un_authorized_user_cannot_access_update_address_component()
    {
        Livewire::test(AddressShowController::class)
            ->assertUnauthorized();
    }

    public function test_authorized_customers_cannot_update_address_with_invalid_data()
    {
        $address = Address::factory()
            ->count(1)
            ->for(State::factory()->for(Country::factory()))
            ->for(User::factory())
            ->create()
            ->first();

        $response = Livewire::actingAs($address->user)
            ->test(AddressShowController::class, [
                'address' => $address,
            ])
            ->set('address.first_name', '')
            ->set('address.last_name', '')
            ->set('address.address_1', '')
            ->call('update');

        $response->assertOk();
        $response->assertHasErrors([
            'address.first_name',
            'address.last_name',
            'address.address_1',
        ]);
    }

    public function test_authorized_customer_can_update_address_with_valid_data()
    {
        $address = Address::factory()
            ->primary()
            ->count(1)
            ->for(State::factory()->for(Country::factory()))
            ->for(User::factory())
            ->create()
            ->first();

        $response = Livewire::actingAs($address->user)
            ->test(AddressShowController::class, [
                'address' => $address,
            ])
            ->set('address.first_name', 'updated1')
            ->set('address.last_name', 'updated2')
            ->call('update');

        $response->assertOk();

        $this->assertCount(
            1,
            Address::query()->where('first_name', 'updated1')->get()
        );

        $this->assertCount(
            1,
            Address::query()->where('last_name', 'updated2')->get()
        );

    }

    public function test_authorized_customer_can_delete_address()
    {
        $response = Livewire::test(CreateAddressController::class);

        $address = Address::factory()
            ->count(1)
            ->for(State::factory()->for(Country::factory()))
            ->for(User::factory())
            ->create()
            ->first();

        $response = Livewire::actingAs($address->user)
            ->test(AddressIndexController::class);

        $response->call('delete', $address->id);

        $response->assertOk();

        $response->assertEmitted(
            'alert-success'
        );

        $this->assertCount(0, Address::query()->ofUser($address->user)->get());
    }

    public function test_authorized_customer_cannot_delete_primary_address()
    {
        $response = Livewire::test(CreateAddressController::class);

        $address = Address::factory()
            ->primary()
            ->count(1)
            ->for(State::factory()->for(Country::factory()))
            ->for(User::factory())
            ->create()
            ->first();

        $response = Livewire::actingAs($address->user)
            ->test(AddressIndexController::class)
            ->call('delete', $address->id);

        $response->assertOk();

        $response->assertEmitted(
            'alert-danger'
        );

        $this->assertCount(1, Address::query()->ofUser($address->user)->get());
    }
}
