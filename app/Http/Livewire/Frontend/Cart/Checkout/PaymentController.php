<?php

namespace App\Http\Livewire\Frontend\Cart\Checkout;

use App\DTO\Payments\PaymentMethod as PaymentMethodDto;
use App\Http\Livewire\Traits\HasCart;
use App\Models\PaymentMethod;
use App\Services\Payments\PaymentMethodService as PaymentsPaymentMethodService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends CheckoutAbstract
{
    use HasCart;

    public string $name = '';

    public string $card_number = '';

    public string $exp_year = '';

    public string $exp_month = '';

    public string $cvc = '';

    public $paymentMethod;

    /**
     * @var array<mixed>
     */
    protected $rules = [
        'name' => 'bail|required',
        'card_number' => 'bail|required',
        'exp_year' => 'bail|required',
        'exp_month' => 'bail|required',
        'cvc' => 'bail|required',
    ];

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function submit()
    {
        $this->validate();

        $paymentMethodDto = new PaymentMethodDto(
            id: Str::random(10),
            name: $this->name,
            cardNumber: $this->card_number,
            expYear: $this->exp_year,
            expMonth: $this->exp_month,
            cvc: $this->cvc,
        );

        try {
            $paymentMethod = PaymentsPaymentMethodService::makeFrom($paymentMethodDto)
                ->withModel(
                    new PaymentMethod()
                )
                ->forUser(Auth::user())
                ->shouldUpdateOnProvider(true)
                ->shouldAttachToCustomer(true)
                ->create();

            $this->paymentMethod = $paymentMethod->id;
            session()->flash('alert-success', trans('notifications.payment_method.created'));

            $this->dispatchBrowserEvent('hidemodal');

            $this->resetFields();
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }

    public function mount()
    {
        if(! $this->cart && isset($this->cart->addresses[1])) {
            return to_route('checkout.billing');
        }

        $this->currentStep = 'payment';
        $this->paymentMethod = $this->cart->meta->payment_id ?? '';
    }

    public function render(): View
    {
        return $this->view('frontend.cart.checkout.payment-controller', function (View $view) {
            /** @phpstan-ignore-next-line */
            $view->layoutData([
                'title' => trans('global.checkout.payment-method'),
                'description' => trans('global.checkout.payment-method'),
            ])
            ->with('paymentMethods', $this->getPaymentMethods());
        });
    }

    public function getPaymentMethods(): Collection
    {
        $query = PaymentMethod::query()->ofUser(Auth::user());

        return $query
            ->latest('is_primary')
            ->get();
    }

    /**
     * Set Payment Method.
     *
     * @param $paymentMethodId
     * @return void
     */
    public function setPaymentMethod()
    {

        if (! $this->paymentMethod) {
            $this->emit('alert-danger', trans('notifications.payment_method.select'));

            return;
        }

        $paymentMethod = PaymentMethod::find($this->paymentMethod);

        $this->cart->meta = [
            'payment_id' => $paymentMethod->id,
            'payment_method_id' => $paymentMethod->payment_method_id,
            'payment_card_number' => $paymentMethod->card_number,
        ];

        $this->cart->save();

        return to_route('checkout.place-order');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->card_number = '';
        $this->exp_year = '';
        $this->exp_month = '';
        $this->cvc = '';
    }
}
