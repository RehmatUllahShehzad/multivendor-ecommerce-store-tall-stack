<x-slot name="pageTitle">
    {{ __('vendor.review.index.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.review.index.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="product-review-first-wrap">
        <div class="product-manage-heading product-review-heading toggling-btn-wrap">
            <div class="header-select">
                <h3>Product Reviews</h3>
                <form method="get">
                    <div class="form-group">
                        <label for="exampleFormControlSelect4">Sort By:</label>
                        <select wire:model="sortBy" class="form-control" id="exampleFormControlSelect4">
                            <option value="">Sort by</option>
                            <option value="oldest">Oldest</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        @forelse ($reviews as $review)
            @include('frontend.vendor.review._partials.review', ['review' => $review])
        @empty
            <div class="product-reviews-wrapper">
                <div class="product-review-cont">
                    <div class="product-text">
                        <h3>Reviews not added yet!</h3>
                    </div>
                </div>
            </div>
        @endforelse

        <div class="text-center product-pagination">
            {{ $reviews->links('frontend.layouts.custom-pagination') }}
        </div>
    </div>
</div>
