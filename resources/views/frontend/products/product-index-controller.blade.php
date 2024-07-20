<div x-data="{
    categoryId: @entangle('categoryId'),
    dietaryRestrictionId: @entangle('dietaryRestrictionId'),

    resetFilters() {
        this.categoryId = [];
        this.dietaryRestrictionId = [];
    },
}" class="inner-section" @resetfields.window="resetFilters">
    <section>
        <div class="whats-new-banner" style="background-image: url('{{ asset('frontend/images/product-listing.png') }}'), linear-gradient(rgba(0,0,0,0.15),rgba(0,0,0,0.15));">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="whats-new-banner-heading">
                            <h1>{{ trans('product.product-heading') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative">
        <div class="container">
            <div class="row">
                <!-- Products Filter Section -->
                <div class="col-md-4 col-lg-3">
                    <livewire:frontend.products.product-filter-controller />
                </div>
                <!-- Products Listing Section -->
                <div class="col-md-8 col-lg-9">
                    <div class="product-listing-search-main div-flex">
                        <div class="input-group">
                            <input class="form-control" type="text" aria-labelledby="look" id="look" placeholder="{{ trans('product.product-search-button-placeholder') }}" wire:model.defer="search">
                            <button class="btn btn-outline-secondary" type="submit" wire:click="getProducts">
                                <span>
                                    <svg style="display: inline-block;" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path style="stroke: none"
                                            d="M22.6159 20.8099L16.8201 15.0141C19.6021 11.3482 19.3237 6.08522 15.9802 2.7417C14.2125 0.973758 11.8616 0 9.36105 0C6.8605 0 4.50963 0.973758 2.7417 2.7417C0.973758 4.50963 0 6.8605 0 9.36105C0 11.8613 0.973758 14.2122 2.7417 15.9802C4.5666 17.8053 6.9637 18.7178 9.36105 18.7178C11.3556 18.7178 13.3491 18.0837 15.0141 16.8201L20.8099 22.6159C21.0589 22.8654 21.3861 22.9901 21.7129 22.9901C22.0396 22.9901 22.3668 22.8654 22.6159 22.6159C23.1147 22.1172 23.1147 21.3085 22.6159 20.8099ZM4.5482 14.1742C3.26229 12.8885 2.55445 11.1793 2.55445 9.36105C2.55445 7.54279 3.26229 5.83361 4.5482 4.54795C5.83361 3.26229 7.54305 2.55445 9.36105 2.55445C11.1791 2.55445 12.8885 3.26229 14.1742 4.5482C16.828 7.20203 16.828 11.5203 14.1742 14.1744C11.5201 16.8282 7.20177 16.8277 4.5482 14.1742Z"
                                            fill="#5e4c2a"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="product-card-main div-flex">
                        @forelse ($products as $product)
                            <div class="new-near-you-block">
                                <a href="{{ route('products.show', $product) }}">
                                    <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->title ?? '' }}">
                                </a>
                                <div class="product-card-text">
                                    <h4>{{ $product->title ?? '' }}</h4>
                                    <a href="{{ route('vendor-profile', $product->user->vendor) }}" class="product-card-description producer">{{ $product->user->name ?? '' }}</a>
                                    <p>${{ number_format($product->price ?? '0.00', 2) }}</p>
                                    <span>
                                        @foreach (range(1, 5) as $stars)
                                            <i class="fas fa-star stars {{ $stars <= $product->approved_reviews_avg_rating ? 'star-active' : ' ' }}"></i>
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

                    <div class="text-center product-pagination">
                        {{ $products->links('frontend.layouts.custom-pagination') }}
                    </div>
                </div>
            </div>

        </div>
        @include('frontend.layouts.livewire.loading')
    </section>
    <livewire:frontend.home.location-popup />
</div>
