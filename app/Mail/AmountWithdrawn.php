<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AmountWithdrawn extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public $toAdmin;

    public float $balance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, float $balance, bool $toAdmin = false)
    {
        $this->queue = 'emails';
        $this->user = $user;
        $this->balance = $balance;
        $this->toAdmin = $toAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('emails.amount-withdrawn-vendor');

        if ($this->toAdmin) {
            return $email->subject('Amount Withdraw Vendor')
            ->to(Setting('information_email'));
        }

        return $email->subject('Amount Withdraw')
            ->to(
                $this->user->email,
                $this->user->name
            );
    }
}
