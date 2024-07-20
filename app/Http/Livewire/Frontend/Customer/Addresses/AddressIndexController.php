<?php

namespace App\Http\Livewire\Frontend\Customer\Addresses;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Models\Address;
use App\Services\Addresses\AddressService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class AddressIndexController extends UserAbstract
{
    use ResetsPagination,
        WithPagination,
        WithBootstrapPagination;

    public function render(): View
    {
        return $this->view('frontend.customer.addresses.address-index-controller', function (View $view) {
            $view->with('addresses', $this->getAddresses());
        });
    }

    protected function getAddresses(): Paginator
    {
        $query = Address::query()->ofUser(Auth::user());

        return $query
            ->latest('is_primary')
            ->paginate(10);
    }

    public function delete(AddressService $addressService, Address $address): void
    {
        try {
            $addressService
                ->withModel($address)
                ->forUser(Auth::user())
                ->delete();

            $this->emit('alert-success', trans('notifications.address.deleted'));
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }
}
