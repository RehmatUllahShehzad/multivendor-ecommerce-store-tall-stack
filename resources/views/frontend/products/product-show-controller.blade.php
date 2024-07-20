<div class="inner-section">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-detail-main">
                        <div class="row">
                            <div class="col-md-6 col-lg-7">
                                <a href="{{ route('products.index') }}" class="prev-page"><img src="{{ asset('frontend/images/caret-left.png') }}" alt="">{{ trans('product.back-link') }}</a>

                                <div class="product-detail-img">
                                    <div class="product-detail-image-upper">
                                        <div class="product-detail-img-upper-slider">
                                            @foreach ($product->getMedia($product::class) as $media)
                                                <img src="{{ $media->getUrl() }}" alt="car">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="product-detail-image-lower product-detail-img-lower-slider mt-4">
                                        @foreach ($product->getMedia($product::class) as $media)
                                            <div class="product-dtl-img-slider">
                                                <img src="{{ $media->getUrl() }}" alt="" class="img-fluid">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-5">
                                <div class="product-description">
                                    <a href="{{ route('vendor-profile', $product->user->vendor ?? '') }}">{{ $this->product->user->vendor->company_name ?? '' }}</a>
                                    <h2>{{ $product->title ?? '' }}</h2>
                                    <div class="product-price-rating">
                                        <h4>${{ number_format($product->price, 2, '.') }}</h4>
                                        <span>
                                            @foreach (range(1, 5) as $stars)
                                                <i class="fas fa-star stars {{ $stars <= $product->approved_reviews_avg_rating ? 'star-active' : ' ' }}"></i>
                                            @endforeach
                                        </span>
                                    </div>
                                    <p>
                                        {!! $product->description ?? '' !!}
                                    </p>

                                    <div class="product-labels">
                                        @foreach ($selectedDietaryRestrictions as $dietaryRestriction)
                                            <span class="badge">{{ $dietaryRestriction }}</span>
                                        @endforeach
                                    </div>
                                    <div class="made-by">
                                        <p>
                                            <b>{{ strtoupper(trans('product.made-by')) }}: <span>
                                                    {{ $product->user->vendor->vendor_name ?? '' }}</span></b>
                                        </p>
                                        <span>{{ $product->user->vendor->bio ?? '' }}</span>
                                    </div>
                                    <div>
                                        @if (!$product->getAvailableStock())
                                            <div class="p-1">
                                                <h4 class="text-center bg-dark p-4 text-white">
                                                    {{ trans('product.out-of-stock') }}</h4>
                                            </div>
                                        @else
                                            <livewire:frontend.shared.add-to-cart-button :product="$product" :wire:key="$product->id" />
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-7">
                                    <div class="product-more-info">
                                        <div class="product-head-main div-flex">
                                            <h3 class="product-info-head">
                                                {{ trans('product.nutritional-information-heading') }}
                                            </h3>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>Value</p>
                                            </div>
                                            @foreach ($product->nutritions as $nutrition)
                                                <div class="col-6">
                                                    <p><strong>{{ $nutrition->name ?? '' }}</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <p><strong>{{ $nutrition->pivot->value ?? '' }} grams</strong></p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    @if (!$product->reviews->isEmpty())
                                        <div class="product-more-info product-review">
                                            <div class="product-head-main div-flex">
                                                <h3 class="product-info-head">{{ trans('product.reviews-heading') }}
                                                </h3>
                                            </div>
                                            @foreach ($product->reviews as $review)
                                                @if ($review->isApproved())
                                                    <div class="review-list-main">
                                                        <div class="review-list">
                                                            <h3>{{ $review->user->name }}</h3>
                                                            <div class="product-price-rating">
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    <i class="fas fa-star stars {{ $i < $review->rating ? 'star-active' : '' }}"></i>
                                                                @endfor
                                                                <h4>{{ $review->created_at->format('m/d/y') }}</h4>
                                                            </div>
                                                            <p>
                                                                {{ $review->comment }}
                                                            </p>
                                                            <p>
                                                                <b>Owner : </b>
                                                                {{ $review->vendor_reply }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                @if ($product->attributes)
                                    <div class="col-sm-6 col-md-7">
                                        <div class="product-more-info">
                                            <h3 class="product-info-head">{{ trans('product.attributes-heading') }}
                                            </h3>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p> {!! $product->attributes ?? '' !!}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                                @if ($product->ingredients)
                                    <div class="col-sm-6 col-md-5">
                                        <div class="product-more-info ps-4">
                                            <h3 class="product-info-head">{{ trans('product.ingredients-heading') }}
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>{!! $this->product->ingredients ?? '' !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
