<?php

namespace App\Http\Livewire\Frontend\Customer\PaymentMethods;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Models\PaymentMethod;
use App\Services\Payments\PaymentMethodService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PaymentMethodIndexController extends UserAbstract
{
    use WithPagination;
    use ResetsPagination;
    use WithBootstrapPagination;

    public function render(): View
    {
        return $this->view('frontend.customer.payment-methods.payment-method-index-controller', function (View $view) {
            $view->with('paymentMethods', $this->getPaymentMethod());
        });
    }

    public function getPaymentMethod(): Paginator
    {
        $query = PaymentMethod::query()->OfUser(Auth::user());

        return $query
            ->latest('is_primary')
            ->paginate(10);
    }

    public function delete(PaymentMethodService $paymentMethodService, PaymentMethod $paymentMethod): void
    {
        try {
            $paymentMethodService
                ->withModel($paymentMethod)
                ->forUser(Auth::user())
                ->shouldUpdateOnProvider(true)
                ->delete();

            $this->emit('alert-success', trans('notifications.payment_method.deleted'));
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }
}
