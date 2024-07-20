<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellNow extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public array $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->queue = 'emails';
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.SellNow')
            ->to(setting('contact_us_email'), setting('site_title'))
            ->subject(trans('global.email.sell-now'));
    }
}
