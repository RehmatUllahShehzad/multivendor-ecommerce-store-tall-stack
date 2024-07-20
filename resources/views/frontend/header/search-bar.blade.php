<div class="search-main-wrapper">
    <div class="search-arrow-set"></div>
    <input type="search" class="form-control" wire:model.debounce.700ms="search" id="exampleFormControlInput1" placeholder="Search the pantry">
    <div class="serach-over-flow-wrap">
        <div wire:loading.remove>
            @if ($isSearched)
                @forelse ($products as $product)
                    <div>
                        @if ($loop->index != 0)
                            <div class="hr search-sp-hr"></div>
                        @endif
                        <div class="search-container">
                            <div class="srch-pic-holder" style="background-image:url('{{ $product->getThumbnailUrl() }}');"></div>
                            <div class="search-data-cont">
                                <h3>
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->title }}
                                    </a>
                                </h3>
                                <div class="description">
                                    {!! $product->description !!}
                                </div>

                                @if (!$product->getAvailableStock())
                                    <div class="p-1">
                                        <h4 class="text-center bg-dark text-white d-inline p-2">{{ trans('product.out-of-stock') }}</h4>
                                    </div>
                                @else
                                    <livewire:frontend.shared.add-to-cart-button :addSearchClass="true" :product="$product" :wire:key="$product->id" />
                                @endif
                            </div>
                            
                            <div class="search-data-price">
                                <h4>${{ number_format($product->price ?? '0.00', 2) }}</h4>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-5 mb-5">
                       <h4> No result found. </h4>
                    </div>
                @endforelse
            @else
                <div> 
                </div>
            @endif
        </div>
        <div wire:loading class="w-100">
            <div class="text-center mt-5 mb-5">
               <h4> Loading... </h4>
            </div>
        </div>
    </div>
</div>
