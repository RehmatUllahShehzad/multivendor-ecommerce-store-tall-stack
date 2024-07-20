<?php

namespace App\Http\Livewire\Frontend\Vendor\Review;

use App\Enums\ReviewStatus;
use App\Http\Livewire\Frontend\VendorAbstract;
use App\Mail\ReviewReply;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReviewShowController extends VendorAbstract
{
    public Review $review;

    public bool $isNew;

    public function mount(): void
    {
        abort_if(! $this->review->product->isOwnedBy(Auth::user()), 404);

        $this->isNew = $this->review->isNew();

        if ($this->isNew) {
            $this->review->setNew(false);
        }
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.review.review-show-controller');
    }

    public function markApproved(): void
    {
        $this->review->setStatus(
            ReviewStatus::APPROVED
        );
    }

    public function markRejected(): void
    {
        $this->review->setStatus(
            ReviewStatus::REJECTED
        );
    }

    public function rules()
    {
        return [
            'review.vendor_reply' => 'required|max:500',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->review->save();

        try {
            Mail::send(new ReviewReply($this->review));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        $this->resetFields();

        $this->dispatchBrowserEvent('close-reply');

        $this->emit('alert-success', trans('notifications.reply.save'));
    }

    public function resetFields(): void
    {
        $this->replyMessage = '';
    }
}
