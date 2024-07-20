
<div class="new-near-you-content new-near-you-new-class">
    <div class="near-you-slider product-card-main near-you-slick ps-0">   
        @forelse (getProducts() as $product)
            <div class="new-near-you-block">
                
                <a href="{{ route('products.show', $product) }}">
                    <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->title ?? '' }}">
                </a>
                <div class="product-card-text">
                    <h4>{{ $product->title ?? '' }}</h4>
                    <a href="{{ route('vendor-profile', $product->user->vendor) }}"
                        class="product-card-description producer">{{ $product->user->name ?? '' }}</a>
                    <p>${{ number_format($product->price ?? '0.00', 2) }}</p>
                    <span>
                        @foreach (range(1, 5) as $stars)
                            <i
                                class="fas fa-star stars {{ $stars <= $product->approved_reviews_avg_rating ? 'star-active' : ' ' }}"></i>
                        @endforeach
                    </span>
                    @if (!$product->getAvailableStock())
                        <div class="p-1">
                            <h4 class="text-center bg-dark">{{ trans('product.out-of-stock') }}</h4>
                        </div>
                    @else
                        <livewire:frontend.shared.add-to-cart-button :product="$product" :wire:key="$product->id" />
                    @endif
                </div>
            </div>

        @empty
            <div>
                {{ trans('catalog.categories.record_not_found') }}
            </div>
        @endforelse
    </div>
    <div class="shimmer-slider container product-card-main near-you-slick ps-0">
        <div class="new-near-you-block shim">
            <div class="shimmer">
                <div class="wrapper">
                <div class="image-card animate"></div>
                <div class="stroke animate title"></div>
                <div class="stroke animate link"></div>
                <div class="stroke animate description"></div>
                </div>
            </div>
        </div>
        <div class="new-near-you-block shim">
            <div class="shimmer">
                <div class="wrapper">
                <div class="image-card animate"></div>
                <div class="stroke animate title"></div>
                <div class="stroke animate link"></div>
                <div class="stroke animate description"></div>
                </div>
            </div>
        </div>
        <div class="new-near-you-block shim">
            <div class="shimmer">
                <div class="wrapper">
                <div class="image-card animate"></div>
                <div class="stroke animate title"></div>
                <div class="stroke animate link"></div>
                <div class="stroke animate description"></div>
                </div>
            </div>
        </div>
    </div>
</div>