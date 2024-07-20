<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorOrderCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    public $orderPackage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderPackage $orderPackage, Order $order)
    {
        $this->queue = 'emails';
        $this->orderPackage = $orderPackage;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('emails.vendor-order-created');

        return $email->to(
            $this->orderPackage->vendor->user->email,
            $this->orderPackage->vendor->user->name
        )->subject("Invoice for order #{$this->order->order_number}");
    }
}
