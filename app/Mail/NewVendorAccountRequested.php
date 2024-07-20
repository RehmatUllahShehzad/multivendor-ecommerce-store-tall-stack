<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVendorAccountRequested extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public Bool $toAdmin = false;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $toAdmin = false)
    {
        $this->queue = 'emails';
        $this->user = $user;
        $this->toAdmin = $toAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('emails.new-vendor-account-requested');

        if ($this->toAdmin) {
            return  $email->subject('Vendor Account Requested')
                ->to(
                    setting('contact_us_email'),
                    setting('site_title')
                );
        }

        return $email->subject('Vendor Account Requested')
            ->to(
                $this->user->email,
                $this->user->name
            );
    }
}
