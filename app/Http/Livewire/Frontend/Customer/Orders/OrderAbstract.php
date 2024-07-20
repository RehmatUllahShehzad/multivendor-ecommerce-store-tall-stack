<?php

namespace App\Http\Livewire\Frontend\Customer\Orders;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Models\Order;

class OrderAbstract extends UserAbstract
{
    public Order $order;
}
