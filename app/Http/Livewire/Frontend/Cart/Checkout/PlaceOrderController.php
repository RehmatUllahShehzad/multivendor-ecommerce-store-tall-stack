<?php

namespace App\Http\Livewire\Frontend\Cart\Checkout;

use App\Enums\ShippingType;
use App\Exceptions\Carts\QuantityExceedException;
use App\Exceptions\Carts\ValidateVendorException;
use App\Facades\SettingFacade;
use App\Http\Livewire\Traits\HasCartMethods;
use App\Mail\OrderCreated;
use App\Mail\VendorOrderCreated;
use App\Managers\PaymentManager;
use App\Models\PaymentMethod;
use App\Models\Vendor;
use App\Services\Cart\CartSessionManager;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Stripe\Exception\CardException;

class PlaceOrderController extends CheckoutAbstract
{
    use HasCartMethods;

    public array $selectedShippingOptions = [];

    public array $payment = [];

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function mount()
    {
        if (! $this->cart) {
            return to_route('homepage');
        }

        $this->currentStep = 'place-order';

        $this->selectedShippingOptions = collect($this->cart?->meta->shippingOptions ?? [])->mapWithKeys(function ($option) {
            return [
                $option->vendor_id => [
                    'selected' => $option->type,
                ],
            ];
        })->toArray();
    }

    public function render(): View
    {
        return $this->view('frontend.cart.checkout.place-order-controller', function (View $view) {
            /** @phpstan-ignore-next-line */
            $view->layoutData([
                'title' => trans('global.checkout.place-order'),
                'description' => trans('global.checkout.place-order'),
            ]);
        });
    }

    public function getServiceFeeProperty()
    {
        return SettingFacade::get('service_fee');
    }

    /**
     * Livewire hook for selectedShippingOption change
     */
    public function updatedSelectedShippingOptions(): void
    {
        $this->updateShippingToCart();
    }

    /**
     * Validate shipping options
     */
    public function validateShippingOptions(): bool
    {
        $this->resetErrorBag();

        $selectedShippingOptions = collect($this->selectedShippingOptions);

        return collect($this->vendors)
            ->filter(function ($vendor) use ($selectedShippingOptions) {
                if (! empty($selectedShippingOptions[$vendor['id']]['selected'])) {
                    return false;
                }

                $this->addError("shipping.{$vendor['id']}.required", 'Shipping Required');

                return true;
            })->isEmpty();
    }

    /**
     * Save shipping changes to cart
     */
    public function updateShippingToCart()
    {
        $cartMeta = $this->cart->meta;

        $cartMeta->shippingOptions = collect($this->selectedShippingOptions)
            ->reject(fn ($option) => strlen($option['selected']) <= 0)
            ->map(function ($option, $vendorId) {
                $vendor = Vendor::find($vendorId);

                $shippingValue = match ($option['selected']) {
                    ShippingType::PICKUP->value => 0,
                    ShippingType::STANDARD_DELIVERY->value => $vendor->standard_delivery_rate,
                    ShippingType::EXPRESS_DELIVERY->value => $vendor->express_delivery_rate
                };

                return [
                    'vendor_id' => $vendorId,
                    'type' => $option['selected'],
                    'value' => $shippingValue,
                ];
            })
            ->toArray();

        $this->cart->meta = $cartMeta;

        $this->cart->save();
    }

    /**
     * Hande the payment submission
     *
     * @return void
     */
    public function submit(CartSessionManager $cartSessionManager)
    {
        if (! $this->validateShippingOptions()) {
            $this->emit('alert-danger', trans('notifications.select.shipping.address'));

            return;
        }

        $this->updateShippingToCart();

        $paymentManager = app(PaymentManager::class);
        try {
            $paymentMethod = PaymentMethod::find($this->cart->meta->payment_id);
            $intent = $paymentManager->createIntentWithCard($this->cart, $paymentMethod->payment_method_id);
            if ($intent) {

                $payment = $paymentManager->driver('stripe')
                    ->cart($this->cart)->withData([
                        'payment_intent' => $intent->id,
                    ])
                    ->setConfig([
                        'released' => 'payment-received',
                    ])
                    ->authorize();

                if ($payment->success) {

                    Mail::send(new OrderCreated($this->cart->order));

                    foreach ($this->cart->order->packages as $package) {
                        Mail::send(new VendorOrderCreated($package, $this->cart->order));
                    }

                    $this->emit('alert-success', __('global.checkout.order_placed'));

                    return to_route('checkout.thankyou');
                }

                session()->flash('alert-danger', __('exceptions.payment_exception'));

                return to_route('checkout.payment');
            }
        } catch (CardException $ex) {
            return $this->emit('alert-danger', $ex->getMessage());
        } catch (QuantityExceedException $ex) {
            return to_route($cartSessionManager->totalQuantity() ? 'checkout.cart' : 'products.index')->with('alert-danger', $ex->getMessage());
        } catch (ValidateVendorException $ex) {
            return to_route('products.index')->with('alert-danger', $ex->getMessage());
        } catch (Exception $ex) {
            return $this->emit('alert-danger', $ex->getMessage());
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->emit('alert-danger', __('product.checkout.order_placed_error'));
    }
}
