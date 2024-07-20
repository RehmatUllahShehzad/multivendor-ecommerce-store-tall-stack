<x-slot name="pageTitle">
    {{ __('vendor.product.index.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.product.index.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div method="get" class="d-block">
        <div class="product-manage-heading toggling-btn-wrap search-setting">
            <div class="header-select">
                <h3>Product Management</h3>

                <div class="form-group">
                    <label for="exampleFormControlSelect12">Sort By:</label>
                    <select class="form-control" wire:model="sortBy" id="exampleFormControlSelect12">
                        <option value="default">Sort by</option>
                        <option value="date">Date</option>
                        <option value="newest">Newest</option>
                        <option value="asc">Name A-Z</option>
                        <option value="desc">Name Z-A</option>
                        <option value="publish">Publish</option>
                        <option value="un_publish">UnPublish</option>
                    </select>
                </div>
            </div>
            <a href="{{ route('vendor.product.create') }}" class="adding-toggle general-btn">
                Add Item
            </a>
        </div>
        <form wire:submit.prevent="getProducts" class="w-100 d-flex">
            <div class="search-wrap">

                <div class="search-in">
                    <div class="input-group">
                        <input wire:model.defer="search" type="text" class="form-control" placeholder="{{ __('vendor.product.index.search_placeholder') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="search-inner">
                    <div class="form-group">
                        <x-lightpick wire:model.defer="dateRange" />

                    </div>
                </div>
                <button class="btn btn-outline-secondary" wire:click="getProducts" type="button">
                    <span>
                        <svg style="display: inline-block;" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path style="stroke: none"
                                d="M22.6159 20.8099L16.8201 15.0141C19.6021 11.3482 19.3237 6.08522 15.9802 2.7417C14.2125 0.973758 11.8616 0 9.36105 0C6.8605 0 4.50963 0.973758 2.7417 2.7417C0.973758 4.50963 0 6.8605 0 9.36105C0 11.8613 0.973758 14.2122 2.7417 15.9802C4.5666 17.8053 6.9637 18.7178 9.36105 18.7178C11.3556 18.7178 13.3491 18.0837 15.0141 16.8201L20.8099 22.6159C21.0589 22.8654 21.3861 22.9901 21.7129 22.9901C22.0396 22.9901 22.3668 22.8654 22.6159 22.6159C23.1147 22.1172 23.1147 21.3085 22.6159 20.8099ZM4.5482 14.1742C3.26229 12.8885 2.55445 11.1793 2.55445 9.36105C2.55445 7.54279 3.26229 5.83361 4.5482 4.54795C5.83361 3.26229 7.54305 2.55445 9.36105 2.55445C11.1791 2.55445 12.8885 3.26229 14.1742 4.5482C16.828 7.20203 16.828 11.5203 14.1742 14.1744C11.5201 16.8282 7.20177 16.8277 4.5482 14.1742Z"
                                fill="#fff"></path>
                        </svg>
                    </span>
                </button>
                <button class="btn btn-outline-secondary" wire:click="resetFields" type="button">Clear</button>
            </div>
        </form>
    </div>
    <div class="managed-products-wrap">
        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-6 cards-mobile-view">
                    <div class="managed-product">
                        <a href="{{ route('products.show', $product) }}" class="managed-product-pic-wrap">
                            <div class="managed-product-pic" style="background-image:url('{{ $product->thumbnail?->getUrl() }}')">
                            </div>
                        </a>
                        <div class="managed-product-detail">
                            <h6>{{ $product->title }}</h6>

                            <div class="product-detail">
                                <p>
                                    <span>{{ $product->is_published == 1 ? 'Published' : 'Unpublished' }}</span>

                                    ${{ $product->price }}<span>{{ $product->created_at->format('m/d/Y') }}</span>
                                </p>
                                <div class="product-edit-delete">
                                    <a href="{{ route('vendor.product.edit', $product->id) }}" class="product-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="product-reviews-wrapper">
                    <div class="product-review-cont">
                        <div class="product-text">
                            <h3>@lang('global.no_records')</h3>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="text-center product-pagination">
        {{ $products->links('frontend.layouts.custom-pagination') }}
    </div>
</div>
