<div class="best-products-content-main">
    <div class="best-products-content">
        <div class="blocks-slider best-products-slider">
            @foreach (getBestProducts() as $product)
                <livewire:frontend.home.best-product-card-controller :product="$product" />
            @endforeach
        </div>
        <div class="shimmer-slider container best-products-slider">
            <div class="best-products-block shim">
                <div class="shimmer">
                    <div class="wrapper">
                        <div class="image-card animate"></div>
                        <div class="stroke animate title"></div>
                        <div class="stroke animate link"></div>
                        <div class="stroke animate description"></div>
                    </div>
                </div>
            </div>
            <div class="best-products-block shim">
                <div class="shimmer">
                    <div class="wrapper">
                        <div class="image-card animate"></div>
                        <div class="stroke animate title"></div>
                        <div class="stroke animate link"></div>
                        <div class="stroke animate description"></div>
                    </div>
                </div>
            </div>
            <div class="best-products-block shim">
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
</div>
