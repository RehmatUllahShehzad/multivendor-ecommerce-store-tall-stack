<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewAdded extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public Review $review;

    public string $reviewComment = '';

    public string $username = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Review $review)
    {
        $this->queue = 'emails';
        $this->review = $review;
        $this->reviewComment = $this->review->comment;
        $this->username = $this->review->product->user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.review-added')
            ->to($this->review->product->user->email, $this->username)
            ->subject('Review Added');
    }
}
