<?php

namespace App\Http\Livewire\Frontend\Vendor\Orders;

use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

/**
 * @property \Illuminate\Contracts\Pagination\Paginator $orders
 */
class OrderIndexController extends OrderAbstract
{
    use WithPagination,
        ResetsPagination,
        WithBootstrapPagination;

    /**
     * @var array<mixed>
     */
    public array $dateRange = [];

    public string $search = '';

    public string $sortBy = 'default';

    public function render(): View
    {
        return $this->view('frontend.vendor.orders.order-index-controller', function (View $view) {
            $view->with('orders', $this->orders);
        });
    }

    public function getOrdersProperty(): Paginator
    {
        $orderPackageTable = (new OrderPackage())->getTable();
        $userTable = (new User())->getTable();
        $orderTable = (new Order())->getTable();
        $cartTable = (new Cart())->getTable();

        $orders = OrderPackage::query()
            ->ofVendor(Auth::user())
            ->select(
                "{$orderPackageTable}.*",
                "{$userTable}.first_name",
                "{$userTable}.last_name",
                "{$orderTable}.order_number",
                "{$orderPackageTable}.id",
            )
            ->when($this->search, function ($query) use ($orderPackageTable) {
                $parts = array_map('trim', explode(' ', $this->search));
                foreach ($parts as $part) {
                    $query->where("{$orderPackageTable}.id", 'LIKE', "%$part%")
                        ->orWhere('order_number', 'LIKE', "%$part%")
                        ->orWhere('first_name', 'LIKE', "%$part%")
                        ->orWhere('last_name', 'LIKE', "%$part%");
                }
            })
            ->join($orderTable, function ($join) use ($orderTable, $cartTable, $userTable, $orderPackageTable) {
                $join->on("{$orderTable}.id", "{$orderPackageTable}.order_id")
                    ->join($cartTable, function ($join) use ($cartTable, $orderTable, $userTable) {
                        $join->on("{$cartTable}.id", "{$orderTable}.cart_id")
                            ->join($userTable, function ($join) use ($cartTable, $userTable) {
                                $join->on("{$cartTable}.user_id", "{$userTable}.id");
                            });
                    });
            })
            ->when(! empty($this->dateRange), function ($query) use ($orderTable) {

                if (isset($this->dateRange[0])) {
                    $query->whereDate("{$orderTable}.created_at", '>=', $this->dateRange[0]);
                }

                if (isset($this->dateRange[1]) && $this->dateRange[1] != '...') {
                    $query->whereDate("{$orderTable}.created_at", '<=', $this->dateRange[1]);
                }
            });

        if ($this->sortBy == 'latest') {
            $orders->latest('created_at');
        }

        if ($this->sortBy == 'oldest') {
            $orders->oldest('created_at');
        }

        if ($this->sortBy == 'asc') {
            $orders->oldest("{$orderPackageTable}.id");
        }

        if ($this->sortBy == 'desc') {
            $orders->latest("{$orderPackageTable}.id");
        }

        if ($this->sortBy == 'a_to_z') {
            $orders->orderBy('first_name', 'ASC');
        }

        if ($this->sortBy == 'z_to_a') {
            $orders->orderBy('first_name', 'DESC');
        }

        return $orders
            ->latest('created_at')
            ->paginate(10);
    }

    public function resetFields(): void
    {
        $this->search = '';
        $this->dateRange = [];
    }
}
