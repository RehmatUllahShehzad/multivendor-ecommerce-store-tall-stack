<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorAccountRejected extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public string $rejectedReason = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $rejectedReason)
    {
        $this->queue = 'emails';
        $this->user = $user;
        $this->rejectedReason = $rejectedReason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendor-account-rejected')
            ->subject('Vendor account request rejected')
            ->to(
                $this->user->email,
                $this->user->name
            );
    }
}
