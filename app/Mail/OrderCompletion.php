<?php

namespace App\Mail;

use App\Models\OrderPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompletion extends Mailable
{
    use Queueable, SerializesModels;

    public OrderPackage $orderPackage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderPackage $orderPackage)
    {
        $this->queue = 'emails';
        $this->orderPackage = $orderPackage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order-completion')
            ->subject('Order Completed')
            ->to(
                $this->orderPackage->customer->email,
                $this->orderPackage->customer->name
            );
    }
}
