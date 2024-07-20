<?php

namespace Tests\Feature\Admin;

use App\Enums\VendorStatus;
use App\Http\Livewire\Admin\Customer\CustomerIndexController;
use App\Http\Livewire\Admin\Customer\CustomerShowController;
use App\Http\Livewire\Admin\Customer\VendorShowController;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorRequest;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class CustomerTest extends TestCase
{
    use WithLogin;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
    }

    public function test_authorized_admin_can_see_customer_listing_page(): void
    {
        $this->loginStaff();

        $response = Livewire::test(CustomerIndexController::class)
            ->call('render');

        $response->assertOk();
    }

    public function test_admin_can_search_customer_by_first_name_last_name_and_email_on_customer_listing_page(): void
    {
        $this->loginStaff();

        $customerList = User::factory()->times(10)->create();

        $randomCustomer = $customerList->random();

        /** Test Search By email */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('search', $randomCustomer->email)
            ->call('render');

        $response->assertOk();
        $response->assertSee($randomCustomer->email);

        /** Test Search by first name */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('search', $randomCustomer->first_name)
            ->call('render');

        $response->assertOk();
        $response->assertSee($randomCustomer->first_name);

        /** Test Search by last name */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('search', $randomCustomer->last_name)
            ->call('render');

        $response->assertOk();
        $response->assertSee($randomCustomer->last_name);

        /** Test Search by invalid keyword */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('search', 'No record found')
            ->call('render');

        $response->assertOk();
    }

    public function test_admin_can_sort_customer_record(): void
    {
        $this->loginStaff();

        $customer = User::factory()->times(3)->create();

        /** Test Sort By ascending order */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('sortBy', 'asc')
            ->call('render');

        $response->assertSeeInOrder([
            $customer[0]['james'],
            $customer[1]['joe'],
            $customer[2]['delia'],
        ]);

        /** Test Sort By descending order */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('sortBy', 'desc')
            ->call('render');

        $response->assertSeeInOrder([
            $customer[2]['james'],
            $customer[1]['joe'],
            $customer[0]['delia'],
        ]);

        /** Test Sort By latest order */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('sortBy', 'latest')
            ->call('render');

        $response->assertSeeInOrder([
            $customer[0]['09/27/22'],
            $customer[1]['09/28/22'],
            $customer[2]['09/30/22'],
        ]);

        /** Test Sort By oldest order */
        $response = Livewire::test(CustomerIndexController::class)
            ->set('sortBy', 'oldest')
            ->call('render');

        $response->assertSeeInOrder([
            $customer[2]['09/27/22'],
            $customer[1]['09/28/22'],
            $customer[0]['09/30/22'],
        ]);
    }

    public function test_admin_can_update_customer_with_valid_data(): void
    {
        $this->loginStaff();

        $customer = User::factory()->create();

        $response = Livewire::test(CustomerShowController::class, [
            'customer' => $customer,
        ])
            ->set('customer.first_name', 'updated first_name')
            ->set('customer.last_name', 'updated last_name')
            ->call('updateCustomer');

        $response->assertOk();

        $this->assertCount(
            1,
            User::query()->where('first_name', 'updated first_name')->get()
        );

        $this->assertCount(
            1,
            User::query()->where('last_name', 'updated last_name')->get()
        );
    }

    public function test_admin_cannot_update_customer_with_invalid_data(): void
    {
        $this->loginStaff();

        $customer = User::factory()->create();

        $response = Livewire::test(CustomerShowController::class, [
            'customer' => $customer,
        ])
            ->set('customer.first_name', '')
            ->set('customer.last_name', '')
            ->set('customer.username', '')
            ->set('customer.email', '')
            ->call('updateCustomer');

        $response->assertOk();
        $response->assertHasErrors([
            'customer.first_name',
            'customer.last_name',
            'customer.username',
            'customer.email',
        ]);
    }

    public function test_admin_can_make_vendor_customer_with_valid_data(): void
    {
        $this->loginStaff();

        $customer = User::factory()->count(1)->create()->first();

        $vendor = Vendor::factory()->count(1)->create()->first();

        $response = Livewire::test(VendorShowController::class, [
            'vendor' => $vendor,
            'customer' => $customer,
        ])
            ->set('vendor.vendor_name', 'james')
            ->set('vendor.company_name', 'dot logics')
            ->set('vendor.bio', 'CEO ')
            ->set('vendor.company_phone', '14323423424')
            ->set('vendor.company_address', 'foo')
            ->call('updateVendor');

        $response->assertHasNoErrors()
            ->assertStatus(200);

        $this->count(1, VendorRequest::query()->approved()->get());
        $this->assertCount(1, Vendor::where('vendor_name', 'james')->get());
    }

    public function test_admin_can_update_vendor_customer_with_valid_data(): void
    {
        $this->loginStaff();

        $customer = User::factory()->count(1)->create()->first();

        $vendor = Vendor::factory()->count(1)->create()->first();

        $response = Livewire::test(VendorShowController::class, [
            'vendor' => $vendor,
            'customer' => $customer,
        ])
            ->set('vendor.vendor_name', 'jamesUpdated')
            ->set('vendor.company_name', 'dot logics Updated')
            ->set('vendor.bio', 'CEO Updated')
            ->call('updateVendor');

        $response->assertOk();

        $this->assertCount(
            1,
            Vendor::query()->where('vendor_name', 'jamesUpdated')->get()
        );

        $this->assertCount(
            1,
            Vendor::query()->where('company_name', 'dot logics Updated')->get()
        );

        $this->assertCount(
            1,
            Vendor::query()->where('bio', 'CEO Updated')->get()
        );
    }

    public function test_admin_cannot_update_vendor_with_invalid_data(): void
    {
        $this->loginStaff();

        $customer = User::factory()->count(1)->create()->first();

        $vendor = Vendor::factory()->count(1)->create()->first();

        $response = Livewire::test(VendorShowController::class, [
            'vendor' => $vendor,
            'customer' => $customer,
        ])
            ->set('vendor.vendor_name', '')
            ->set('vendor.company_name', '')
            ->set('vendor.bio', ' ')
            ->set('vendor.company_phone', '')
            ->set('vendor.company_address', '')
            ->call('updateVendor');

        $response->assertOk();
        $response->assertHasErrors([
            'vendor.vendor_name',
            'vendor.company_name',
            'vendor.bio',
            'vendor.company_phone',
            'vendor.company_address',
        ]);
    }

    public function test_admin_can_view_vendor_requests(): void
    {
        $this->loginStaff();

        $customer = User::factory()->count(1)->create()->first();

        $response = Livewire::test(CustomerShowController::class, [
            'customer' => $customer,
            'vendorRequests' => VendorRequest::query()
                ->where('user_id', $customer->id),
        ])->call('render');

        $response->assertOk();
    }

    public function test_admin_can_approve_vendor_request(): void
    {
        $this->loginStaff();

        $customer = User::factory()->count(1)->create()->first();

        $vendorRequest = VendorRequest::factory()->count(1)->create([
            'user_id' => $customer->id,
            'status' => 'pending',
            'rejected_reason' => null,
        ])->first();

        $response = Livewire::test(CustomerShowController::class, [
            'customer' => $customer,
            'vendorRequests' => VendorRequest::query()
                ->where('user_id', $customer->id),
        ])->call('approvedRequest', $vendorRequest->id);

        $vendorRequest->status = VendorStatus::Approved;

        $response->assertOk();
        $this->count(1, VendorRequest::query()->approved()->get());
    }

    public function test_admin_can_reject_vendor_request(): void
    {
        $this->loginStaff();

        $customer = User::factory()->count(1)->create()->first();

        $vendorRequest = VendorRequest::factory()->count(1)->create([
            'user_id' => $customer->id,
            'status' => 'pending',
            'rejected_reason' => null,
        ])->first();

        $response = Livewire::test(CustomerShowController::class, [
            'customer' => $customer,
            'vendorRequests' => VendorRequest::query()
                ->where('user_id', $customer->id),
        ])->call('rejectRequest', $vendorRequest->id);

        $vendorRequest->status = VendorStatus::Rejected;
        $vendorRequest->rejected_reason = 'Not Interested';

        $response->assertOk();
        $this->count(1, VendorRequest::query()->rejected()->get());
    }
}
