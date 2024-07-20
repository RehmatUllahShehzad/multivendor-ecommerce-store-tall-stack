<?php

namespace App\Http\Livewire\Frontend\Vendor\Orders;

use App\Enums\OrderStatus;
use App\Mail\OrderCompletion;
use App\Mail\TrackingIdAdded;
use App\Models\CartAddress;
use App\Services\Cart\Actions\CreateVendorPackageTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderShowController extends OrderAbstract
{
    /**
     * The Order status enum for the order status we want to show.
     *
     * @var \App\Enums\OrderStatus
     */
    public $status;

    public ?string $tracking_number = null;

    public function mount(): void
    {
        abort_if(! $this->order->isOwnedBy(Auth::user()), 404);
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.orders.order-show-controller');
    }

    public function getShippingAddressProperty(): CartAddress
    {
        return $this->order->order->shippingAddress;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function update()
    {
        $this->validate([
            'status' => 'required|in:'.collect(OrderStatus::cases())->map(fn ($case) => $case->value)->implode(','),
        ]);

        $this->order->status = $this->status;
        $this->order->update();

        try {
            if ($this->order->status == OrderStatus::Completed) {
                app(CreateVendorPackageTransaction::class)
                    ->setSummary(sprintf('Pending clearance at %s <a href="%s" target="blank" >(View Order)</a>', now()->format('m/d/Y'), route('vendor.orders.show', $this->order->id)))
                    ->setAvailableAt(now()->addDays(setting('order_payment_processing_time')))
                    ->execute($this->order);

                Mail::send(new OrderCompletion($this->order));
            }
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        session()->flash('alert-success', trans('notifications.order.status_updated'));

        return to_route('vendor.orders');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function submit()
    {
        $this->validate([
            'tracking_number' => 'required|numeric|unique:order_packages,tracking_number,'.$this->order->id,
        ]);

        $this->order->tracking_number = $this->tracking_number;

        try {
            Mail::send(new TrackingIdAdded($this->order, $this->tracking_number));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        $this->order->update();

        $this->tracking_number = '';
        $this->emit('alert-success', trans('notifications.order.tracking_number_updated'));
    }

    /**
     * @return \App\Enums\OrderStatus
     */
    public function getOrderStatuses()
    {
        return OrderStatus::cases();
    }
}
