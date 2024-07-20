<?php

namespace App\Mail\Admin;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;

class ResetPasswordEmail extends Mailable
{
    /**
     * The token for the reset.
     *
     * @var string
     */
    public $token;

    /**
     * New instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset your password')
            ->markdown('emails.admin.password-reset', [
                'link' => URL::temporarySignedRoute(
                    'admin.password-reset',
                    now()->addMinutes(30),
                    ['token' => $this->token]
                ),
            ]);
    }
}
