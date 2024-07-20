<?php

namespace App\Http\Livewire\Frontend\Cart\Checkout;

use App\Enums\AddressType;
use App\Http\Livewire\Traits\HasCart;
use App\Models\Address;
use App\Models\CartAddress;
use App\Rules\ZipCode;
use App\Services\Addresses\AddressService;
use App\Services\GoogleApi\GoogleApiService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AddressController extends CheckoutAbstract
{
    use HasCart;

    /**
     * The address model for the address we want to show.
     */
    public Address $address;

    /**
     * Set Address as Primary
     *
     * @var bool
     */
    public bool $isPrimary;

    /**
     * Is the billing address same as shipping address
     *
     * @var bool
     */
    public $billingSameAsShipping = false;

    public function mount()
    {
        $this->address = new Address();

        $this->isPrimary = false;

        if (! isset($this->cart->addresses[0]) && request()->routeIs('checkout.billing')) {
            return to_route('checkout.shipping');
        }

        if (request()->routeIs('checkout.billing')) {
            $this->currentStep = 'billing';
        }

        if (request()->routeIs('checkout.shipping')) {
            $this->currentStep = 'shipping';
        }

        $address = Address::query()->ofUser(Auth::user())->primary()->first();

        if ($address) {
            $this->{"set{$this->currentStep}Address"}($address);
        }
    }

    public function render(): View
    {

        return $this->view('frontend.cart.checkout.address-controller', function (View $view) {
            /** @phpstan-ignore-next-line */
            $view->layoutData([
                'title' => trans('global.checkout.shipping-address'),
                'description' => trans('global.checkout.shipping-address'),
            ])
                ->with('addresses', $this->getAddresses());
        });
    }

    /**
     * The validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'address.first_name' => 'bail|required|min:3|max:30',
            'address.last_name' => 'bail|required|min:3|max:30',
            'address.phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
            'address.address_1' => 'bail|required|nullable|max:100',
            'address.address_2' => 'bail|nullable|max:100',
            'address.city' => 'bail|required|max:100',
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

    protected function getAddresses(): Collection
    {
        $query = Address::query()->ofUser(Auth::user());

        return $query
            ->latest('is_primary')
            ->get();
    }

    /**
     * Save the address for a given type.
     *
     *
     * @return void
     */
    public function saveAddress(AddressService $addressService)
    {
        $this->address->phone = preg_replace('/[^0-9]/', '', $this->address->phone);

        $this->validate();

        try {
            $this->address->country_id = 233;

            $addressService->withModel($this->address)
                ->forUser(Auth::user())
                ->setPrimary($this->isPrimary)
                ->save();

            if ($this->address->is_primary == true) {
                $this->{"set{$this->currentStep}Address"}($this->address);
            }

            $this->emit('alert-success', trans('notifications.address.created'));
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }

        $this->dispatchBrowserEvent('hidemodal');

        $this->address = new Address();
    }

    public function editAddress(Address $address)
    {
        $this->address = $address;

        $this->dispatchBrowserEvent('showmodal');
    }

    public function setPrimaryAddress(Address $address)
    {
        $this->address = $address;

        Address::query()->ofUser(Auth::user())
            ->update([
                'is_primary' => false,
            ]);

        $this->address->is_primary = true;

        $this->address->save();

        $this->{"set{$this->currentStep}Address"}($address);
    }

    public function delete(AddressService $addressService, Address $address): void
    {

        try {
            $addressService
                ->withModel($address)
                ->forUser(Auth::user())
                ->delete();

            $this->emit('alert-success', trans('notifications.address.deleted'));
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }

    /**
     * Set the shipping address.
     *
     * @param  Address  $address
     * @return \App\Models\Cart
     */
    public function setShippingAddress(Address $address)
    {
        $this->saveCartAddress($address, AddressType::SHIPPING);

        $this->cart->load('shippingAddress');

        return $this;
    }

    /**
     * Set the billing address.
     *
     * @param  Address  $address
     * @return self
     */
    public function setBillingAddress(Address $address)
    {
        $this->saveCartAddress($address, AddressType::BILLING);

        $this->cart->load('billingAddress');

        return $this;
    }

    public function updatedBillingSameAsShipping(): void
    {
        if (! $this->billingSameAsShipping) {
            return;
        }

        /**
         * Delete Existing billing addresses if any.
         */
        $this->cart->billingAddress()->delete();

        /**
         * Replicate shipping address to billing address and save.
         */

        /** @var \App\Models\CartAddress $shippingAddress */
        $shippingAddress = $this->cart->shippingAddress ?? new CartAddress();

        if ($shippingAddress->exists) {
            $shippingAddress = $shippingAddress->replicate();
        }

        $shippingAddress->type = AddressType::BILLING;

        $shippingAddress->save();

        $this->emit('alert-success', trans('notifications.set.shipping.address'));
    }

    /**
     * Add an address to the.
     *
     * @param  Address  $address
     * @param [type] $type
     * @return void
     */
    private function saveCartAddress(Address $address, $type)
    {
        $cartAddress = $this->cart->addresses()->addressType($type)->firstOrNew();

        $cartAddress->latLng = app(GoogleApiService::class)
            ->getCoordinates(implode(', ', array_filter([
                $address->address_1,
                $address->address_2,
                $address->city,
                $address->state->name ?? null,
                $address->zip,
            ])));

        $meta = $cartAddress->meta;
        $meta->user_address_id = $address->id;

        $data = [
            ...$address->toArray(),
            'type' => $type,
            'cart_id' => $this->cart->id,
            'meta' => $meta,
        ];

        $cartAddress->fill(Arr::except($data, [
            'id',
            'user_id',
            'is_primary',
            'created_at',
            'updated_at',
            'updated_at',
            'address_type',
            'state',
        ]));

        $cartAddress->save();

        $this->emit('alert-success', trans('notifications.address.selected'));
    }

    public function getSelectedUserAddressIdProperty()
    {
        return $this->cart->{"{$this->currentStep}Address"}->meta->user_address_id ?? null;
    }
}
