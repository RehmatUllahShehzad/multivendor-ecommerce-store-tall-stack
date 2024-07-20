<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\Order;
use Closure;

abstract class OrderModifier
{
    public function creating(Cart $cart, Closure $next): Cart
    {
        return $next($cart);
    }

    public function created(Order $order, Closure $next): Order
    {
        return $next($order);
    }
}
