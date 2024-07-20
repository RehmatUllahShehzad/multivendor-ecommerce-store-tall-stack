<?php

namespace App\Http\Livewire\Frontend\Customer\Orders;

use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class OrderIndexController extends OrderAbstract
{
    use WithPagination,
        ResetsPagination,
        WithBootstrapPagination;

    public string $sortBy = 'default';

    public function render(): View
    {
        return $this->view('frontend.customer.orders.orders-index-controller', function (View $view) {
            $view->with('orders', $this->getOrders());
        });
    }

    protected function getOrders(): Paginator
    {
        $query = Auth::user()
            ->orders();

        if ($this->sortBy == 'latest') {
            $query->latest('created_at');
        }

        if ($this->sortBy == 'oldest') {
            $query->oldest('created_at');
        }

        if ($this->sortBy == 'order_asc') {
            $query->oldest('id');
        }

        if ($this->sortBy == 'order_desc') {
            $query->latest('id');
        }

        if ($this->sortBy == 'price_asc') {
            $query->oldest('total_amount');
        }

        if ($this->sortBy == 'price_desc') {
            $query->latest('total_amount');
        }

        if ($this->sortBy == 'status_pro') {
            $query->whereRelation('packages', 'status', 'processing');
        }

        if ($this->sortBy == 'status_com') {
            $query->whereRelation('packages', 'status', 'completed');
        }

        return $query
            ->latest('created_at')
            ->paginate(10);
    }
}
