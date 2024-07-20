<?php

namespace Tests\Feature\Frontend\Vendor;

use App\Http\Livewire\Frontend\Vendor\ProfileController;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class ProfileTest extends TestCase
{
    use WithLogin;

    public function test_guest_cannot_see_vendor_edit_profile_page(): void
    {
        $response = $this->get(route('vendor.profile'));

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_customer_cannot_access_vendor_edit_profile_page(): void
    {
        $this->loginUser();

        $response = $this->get(route('vendor.profile'));

        $response->assertRedirect(
            route('customer.dashboard')
        );
    }

    public function test_vendor_can_see_edit_profile_page(): void
    {
        $user = $this->loginUser(true);

        $response = $this->get(route('vendor.profile'));

        $response->assertStatus(200);
    }

    public function test_vendor_can_update_profile_with_valid_data(): void
    {
        $this->loginUser(true);

        $response = Livewire::test(ProfileController::class)
            ->set('vendor.vendor_name', 'test')
            ->set('vendor.bio', 'test')
            ->set('vendor.company_name', 'test')
            ->set('vendor.company_phone', '12345678911')
            ->set('vendor.company_address', 'test address')
            ->set('vendor.deliver_products', false)
            ->set('profileImage', UploadedFile::fake()->image('avatar.jpg'))
            ->set('bannerImage', UploadedFile::fake()->image('avatar.jpg'))
            ->call('submit');

        $response->assertEmitted('alert-success');
    }

    public function test_vendor_cannot_update_profile_with_invalid_data(): void
    {
        $this->loginUser(true);

        $response = Livewire::test(ProfileController::class)
            ->set('vendor.vendor_name', '')
            ->set('vendor.bio', '')
            ->set('vendor.company_name', '')
            ->set('vendor.company_phone', '')
            ->set('vendor.company_address', '')
            ->call('submit');

        $response->assertHasErrors([
            'vendor.vendor_name',
            'vendor.bio',
            'vendor.company_name',
            'vendor.company_phone',
            'vendor.company_address',
        ]);
    }

    public function test_vendor_cannot_update_shipping_information_with_invalid_data(): void
    {
        $this->loginUser(true);

        $response = Livewire::test(ProfileController::class)
            ->set('vendor.deliver_products', 1)
            ->set('vendor.deliver_up_to_max_miles', '-1')
            ->set('vendor.express_delivery_rate', '-1')
            ->set('vendor.standard_delivery_rate', '-1')
            ->call('submit');

        $response->assertHasErrors([
            'vendor.deliver_up_to_max_miles',
            'vendor.express_delivery_rate',
            'vendor.standard_delivery_rate',
        ]);
    }

    public function test_vendor_can_update_shipping_information_with_valid_data()
    {
        $this->loginUser(true);

        $response = Livewire::test(ProfileController::class)
            ->set('vendor.deliver_products', 1)
            ->set('vendor.deliver_up_to_max_miles', 10)
            ->set('vendor.express_delivery_rate', 12)
            ->set('vendor.standard_delivery_rate', 12)
            ->call('submit');

        $response->assertOk();
    }
}
