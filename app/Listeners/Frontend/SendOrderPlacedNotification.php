<?php

namespace App\Listeners\Frontend;

use App\Events\Frontend\OrderPlaced;
use Illuminate\Support\Facades\Mail;

class SendOrderPlacedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Frontend\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $order = $event->order;
        $email = $order->customer->email;

        if (empty($email)) {
            return;
        }

        Mail::raw('Your order is placed. ', function ($message) use ($order, $email) {
            $message
                ->subject("Order: {$order->order_number}")
                ->to($email);
        });
    }
}
