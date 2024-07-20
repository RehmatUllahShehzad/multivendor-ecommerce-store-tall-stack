<?php

namespace App\Http\Livewire\Frontend\Customer\Addresses;

use App\Rules\ZipCode;
use App\Services\Addresses\AddressService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AddressShowController extends AddressAbstract
{
    public function mount(): void
    {
        if (! $this->address->isOwnedBy(Auth::user())) {
            abort(401);
        }

        $this->isPrimary = (bool) $this->address->isPrimary();
    }

    public function render(): View
    {
        return $this->view('frontend.customer.addresses.address-show-controller');
    }

    /**
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'address.first_name' => 'bail|required|min:3|max:30',
            'address.last_name' => 'bail|required|min:3|max:30',
            'address.phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
            'address.address_1' => 'bail|required|nullable|max:100',
            'address.address_2' => 'bail|nullable|max:100',
            'address.city' => 'bail|required',
            'address.state_id' => 'bail|required',
            'address.zip' => [
                'bail',
                'required',
                'max:10',
                new ZipCode($this->address->state_id),
            ],
            'address.address_type' => 'bail|required|max:10',
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function update(AddressService $addressService)
    {
        $this->address->phone = preg_replace('/[^0-9]/', '', $this->address->phone);

        $this->validate();

        try {
            $addressService->withModel($this->address)
                ->forUser(Auth::user())
                ->setPrimary($this->isPrimary)
                ->save();

            session()->flash('alert-success', trans('notifications.address.updated'));

            return to_route('customer.addresses.index');
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }
}
