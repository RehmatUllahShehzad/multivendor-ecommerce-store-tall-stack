<?php

namespace App\Http\Livewire\Frontend\Customer\Orders;

use App\Models\CartAddress;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * @property \Illuminate\Support\Optional $lastTransaction
 * @property \App\Models\Transaction $lastTransaction->card_type
 */
class OrderShowController extends OrderAbstract
{
    public bool $showForm = false;

    public Review $rating;

    public ?int $ratingValue = null;

    public ?string $comment = null;

    public function mount(): void
    {
        abort_if(! $this->order->isOwnedBy(Auth::user()), 404);

        $this->order->load('reviews', 'packages.items.product');
    }

    public function render(): View
    {
        return $this->view('frontend.customer.orders.orders-show-controller');
    }

    public function getShippingAddressProperty(): CartAddress
    {
        return $this->order->shippingAddress;
    }

    /**
     * The Card property
     *
     * @return \Illuminate\Support\Optional
     */
    public function getCardProperty()
    {
        return optional((object) [
            'card_type' => $this->lastTransaction->card_type,
            'last_four' => $this->lastTransaction->last_four,
        ]);
    }

    public function getLastTransactionProperty(): Transaction
    {
        return $this->order->transactions()->latest()->first();
    }

    public function rate(Product $product): void
    {

        $this->validate([
            'ratingValue' => 'required|min:0,max:5',
            'comment' => 'required',
        ]);

        if ($this->order->hasReviewFor($product)) {
            $this->emit('alert-danger', trans('notifications.product.review.already.added'));

            return;
        }

        $this->order->addReview($product, $this->comment, $this->ratingValue);

        $this->dispatchBrowserEvent('close-modal');
        $this->emit('alert-success', trans('notifications.product.review.added'));
    }

    public function resetFields(): void
    {
        $this->ratingValue = 0;
        $this->comment = '';
    }
}
