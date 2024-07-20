<a class="product-reviews-wrapper" href="{{ route('vendor.review.show', $review) }}">
    <div class="product-review-cont">
        <div class="product-image" style="background-image: url({{ $review->product->getThumbnailUrl() }})">
        </div>
        <div class="product-text">
            <h3>{{ $review->product->title }}</h3>
            <div class="review-star">
                @for ($i = 0; $i < 5; $i++)
                    <i class="fas fa-star stars {{ $i < $review->rating ? 'star-active' : '' }}"></i>
                @endfor
            </div>
            <p>
                {{ $review->short_comment }}
            </p>
            <div class="review-date-time">
                <p>
                    <span>{{ $review->user->name }}</span>
                    <span>|</span>
                    {{ $review->created_at->format('m-d-Y - h:m a') }}
                </p>
            </div>
        </div>

        @if ($review->isRejected())
            <span class="decline" data-bs-toggle="tooltip" data-placement="bottom" title=" {{ $review->status() }} ">
                <i class="fas fa-times-circle"></i>
            </span>
        @elseif($review->isApproved())
            <span class="approve" data-bs-toggle="tooltip" data-placement="bottom" title=" {{ $review->status() }} ">
                <i class="fas fa-check-circle"></i>
            </span>
        @else
            <span class="new" data-bs-toggle="tooltip" data-placement="bottom" title=" {{ $review->status() }} ">
                <i class="fas fa-clock"></i>
            </span>
        @endif

    </div>
</a>
