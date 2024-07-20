<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewReply extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public Review $review;

    public $reviewSubject;

    public $reviewComment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Review $review)
    {
        $this->queue = 'emails';
        $this->review = $review;
        $this->reviewSubject = $this->review->comment;
        $this->reviewComment = $this->review->vendor_reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.review-reply')
            ->to($this->review->user->email, $this->review->user->name)
            ->subject('Review Reply');
    }
}
