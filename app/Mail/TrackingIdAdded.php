<?php

namespace App\Mail;

use App\Models\OrderPackage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrackingIdAdded extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public string $trackingId = '';

    public string $username = '';

    public OrderPackage $orderPackage;

    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderPackage $orderPackage, string $trackingId)
    {
        $this->queue = 'emails';
        $this->orderPackage = $orderPackage;
        $this->user = $orderPackage->user;
        $this->trackingId = $trackingId;
        $this->username = $this->user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.trackingId-added')
            ->to($this->user->email, $this->user->name)
            ->subject('Tracking ID');
    }
}
