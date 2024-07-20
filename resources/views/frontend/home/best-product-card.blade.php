<div class="best-products-block">
    <a href="{{ route('products.show', $product) }}">
        <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->title ?? '' }}">
    </a>
    <h4>{{ $product->title ?? '' }}</h4>
    <a href="{{ route('vendor-profile', $product->user->vendor) }}" class="product-card-description producer">{{ $product->user->name ?? '' }}</a>
    <p>${{ number_format($product->price ?? '0.00', 2) }}</p>
    @foreach (range(1, 5) as $stars)
        <i class="fas fa-star stars {{ $stars <= $product->approved_reviews_avg_rating ? 'star-active' : ' ' }}"></i>
    @endforeach
   
    <livewire:frontend.shared.add-to-cart-button :product="$product" :wire:key="$product->id" />
</div>
