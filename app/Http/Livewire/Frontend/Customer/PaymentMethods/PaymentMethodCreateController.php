<?php

namespace App\Http\Livewire\Frontend\Customer\PaymentMethods;

use App\DTO\Payments\PaymentMethod as PaymentMethodDto;
use App\Models\PaymentMethod;
use App\Services\Payments\PaymentMethodService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentMethodCreateController extends PaymentMethodsAbstract
{
    public string $name = '';

    public string $card_number = '';

    public string $exp_year = '';

    public string $exp_month = '';

    public string $cvc = '';

    public function mount(): void
    {
        $this->isPrimary = false;
    }

    public function render(): View
    {
        return $this->view('.frontend.customer.payment-methods.payment-method-create-controller');
    }

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
            PaymentMethodService::makeFrom($paymentMethodDto)
                ->withModel(
                    new PaymentMethod()
                )
                ->forUser(Auth::user())
                ->setPrimary($this->isPrimary)
                ->shouldUpdateOnProvider(true)
                ->shouldAttachToCustomer(true)
                ->create();

            session()->flash('alert-success', trans('notifications.payment_method.created'));

            return to_route('customer.payment.index');
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }
}
