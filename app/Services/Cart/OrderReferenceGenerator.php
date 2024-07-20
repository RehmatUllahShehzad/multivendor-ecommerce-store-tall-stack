<?php

namespace App\Services\Cart;

use App\Models\Order;
use Closure;
use Illuminate\Support\Facades\DB;

class OrderReferenceGenerator
{
    /**
     * The override generator.
     *
     * @var \Closure
     */
    protected ?Closure $overrideCallback = null;

    public function generate(Order $order): string
    {
        if ($this->overrideCallback) {
            return call_user_func($this->overrideCallback, $order);
        }

        $year = $order->created_at->year;

        $month = $order->created_at->format('m');

        $latest = Order::select(
            DB::RAW('MAX(order_number) as order_number')
        )->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->where('id', '!=', $order->id)
            ->first();

        if (! $latest || ! $latest->order_number) {
            $increment = 1;
        } else {
            $segments = explode('-', $latest->order_number);

            if (count($segments) == 1) {
                $increment = 1;
            } else {
                $increment = end($segments) + 1;
            }
        }

        return $year.'-'.$month.'-'.str_pad($increment, 4, 0, STR_PAD_LEFT);
    }

    /**
     * Override the current method of generating a order_number.
     *
     * @param  Closure  $callback
     * @return self
     */
    public function override(Closure $callback)
    {
        $this->overrideCallback = $callback;

        return $this;
    }
}
