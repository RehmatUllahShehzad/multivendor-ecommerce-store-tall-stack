<?php

namespace App\Http\Livewire\Admin\Order;

use App\Models\Order;

class OrderShowController extends OrderAbstract
{
    public Order $order;

    public function render()
    {
        return $this->view('admin.order.order-show-controller');
    }
}
