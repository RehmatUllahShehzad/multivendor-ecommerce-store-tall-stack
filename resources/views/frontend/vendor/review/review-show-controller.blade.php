<x-slot name="pageTitle">
    {{ __('vendor.review.detail.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.review.detail.title') }}
</x-slot>
<div class="vender-product-management-right" x-data="{
    vendorReply: false,
}" x-on:close-reply="vendorReply=false">
    <div class="product-review-second-wrap">
        <div class="product-manage-heading product-review-heading">
            <div class="header-select">
                <h3>Product Reviews</h3>
            </div>
        </div>
        <div class="product-reviews-wrapper">
            <div class="product-review-cont">
                <div class="product-image" style="background-image: url({{ $review->product->getThumbnailUrl() }})">
                </div>
                <div class="product-text">
                    <div class="product-text-wrapper">
                        <h3>{{ $review->product->title }}
                            @if ($isNew)
                                <span>New</span>
                            @endif
                        </h3>

                        <div class="review-star">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star stars {{ $i < $review->rating ? 'star-active' : '' }}"></i>
                            @endfor
                        </div>
                        <p>
                            {{ $review->comment }}
                        </p>
                        <div class="review-date-time">
                            <p>
                                <span>{{ $review->user->name }}</span>
                                <span>|</span>
                                {{ $review->created_at->format('m-d-Y - h:m a') }}
                            </p>
                        </div>
                        <div class="review-butn-wrap">
                            <div class="approve-reject-btn">
                                @if ($review->isPending())
                                    <button class="approve-btn" type="button" wire:loading.attr="disabled" wire:click="markApproved()">
                                        Approve
                                        <x-button-loading wire:loading wire:target="markApproved" />
                                    </button>
                                    <button class="reject-btn" type="button" wire:loading.attr="disabled" wire:click="markRejected()">
                                        Reject
                                        <x-button-loading wire:loading wire:target="markRejected" />
                                    </button>
                                @else
                                    <h5 class="{{ $review->isApproved() ? 'text-success' : 'text-danger' }}">{{ $review->status() }}</h5>
                                @endif
                            </div>
                            @if (empty($review->vendor_reply))
                                <a class="reply-btn" href="javascript:void(0)" @click="vendorReply = !vendorReply">Reply</a>
                            @endif
                        </div>
                    </div>
                    <div class="reply-form-wrapper">
                        @if (!empty($review->vendor_reply))
                            <h4>Vendor Reply</h4>
                            <p>
                                {{ $review->vendor_reply }}
                            </p>
                            <a class="edit-btn" href="javascript:void(0)" @click="vendorReply = !vendorReply">Edit</a>
                        @endif
                        <div class="reply-form-container" id="" :class="{ 'd-block': vendorReply }" x-on:click.away="show=false">
                            <h5>Reply</h5>
                            <form wire:submit.prevent="submit">
                                <div class="form-group">
                                    <textarea class="form-control" id="" aria-labelledby="exampleFormControlTextarea1" wire:model.defer="review.vendor_reply" rows="3" placeholder="Please reply..."></textarea>
                                    @error('review.vendor_reply')
                                        <div class="error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="checkout-cart-button" type="submit">
                                    Submit
                                    <x-button-loading wire:loading wire:target="submit" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
