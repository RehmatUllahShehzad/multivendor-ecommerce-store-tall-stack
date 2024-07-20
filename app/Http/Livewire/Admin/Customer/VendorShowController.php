<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Models\Vendor;
use Illuminate\Contracts\View\View;

class VendorShowController extends CustomerAbstract
{
    public ?Vendor $vendor = null;

    /**
     * @var array<string,string>
     */
    protected $rules = [
        'vendor.vendor_name' => 'required|max:30',
        'vendor.company_name' => 'required|max:191',
        'vendor.bio' => 'required|max:500',
        'vendor.company_phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
        'vendor.company_address' => 'required|max:191',
    ];

    public function mount(): void
    {
        $this->vendor = $this->customer->vendor;

        if (empty($this->vendor)) {
            $this->vendor = new Vendor();
        }
    }

    public function render(): View
    {
        return view('admin.customer.vendor-show-controller');
    }

    public function updateVendor(): void
    {
        $this->validate();

        $this->vendor->save();

        $this->notify(trans('notifications.vendor.updated'), 'admin.customer.index');

        if (! $this->customer->vendor instanceof Vendor) {
            $this->notify(trans('notifications.vendor.created'), 'admin.customer.index');
        }

    }
}
