<?php

namespace App\Http\Livewire\Frontend\Vendor\Orders;

use App\Http\Livewire\Frontend\VendorAbstract;
use App\Models\OrderPackage;

class OrderAbstract extends VendorAbstract
{
    /**
     * The OrderPackage model for the OrderPackage we want to show.
     */
    public OrderPackage $order;
}
