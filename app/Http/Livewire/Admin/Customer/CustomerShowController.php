<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Models\VendorRequest;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class CustomerShowController extends CustomerAbstract
{
    protected Collection $vendorRequests;

    /**
     * Should the browser be visible?
     *
     * @var bool
     */
    public bool $showBrowser = false;

    /**
     * Should the field be visible?
     *
     * @var bool
     */
    public bool $showField = false;

    public ?string $rejected_reason = null;

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'customer.first_name' => 'required|max:30',
            'customer.last_name' => 'required|max:30',
            'customer.username' => 'required|max:30',
            'customer.email' => 'required|email|max:50|unique:'.get_class($this->customer).',email,'.$this->customer->id,
        ];
    }

    public function render(): View
    {
        return $this->view('admin.customer.customer-show-controller', function (View $view) {
            $view->with('vendorRequests', $this->getVendorRequests());
        });
    }

    public function updateCustomer(): void
    {
        $this->validate();

        $this->customer->save();

        $this->notify(trans('notifications.customer.updated'), 'admin.customer.index');
    }

    public function getVendorRequests(): Paginator
    {
        $query = VendorRequest::query()
            ->where('user_id', $this->customer->id);

        return $query->paginate(5);
    }

    public function approvedRequest(VendorRequest $vendorRequest): void
    {
        try {
            $vendorRequest->approveRequest()->makeVendor();
        } catch (Exception $ex) {
            $this->emit('alert-danger', $ex->getMessage());
        }

        $this->notify(trans('notifications.vendor_request_updated'), 'admin.customer.index');
    }

    public function rejectRequest(VendorRequest $vendorRequest): void
    {
        $this->validate(
            ['rejected_reason' => 'required']
        );

        $vendorRequest->rejectWithReason($this->rejected_reason);

        $this->notify(trans('notifications.vendor_request_updated'), 'admin.customer.index');
    }
}
