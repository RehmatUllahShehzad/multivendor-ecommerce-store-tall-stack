@extends('frontend.layouts.master')

@section('meta_title', 'Homepage')
@section('meta_description', '')

@section('page')
    <div class="inner-section">

        <!-- Hero banner  -->
        <section>
            <form action="{{ route('products.index') }}" method="GET">
                <div class="new-banner">
                    <img src="{{ asset('frontend/images/banner.jpg') }}" alt="Healthy Food" />
                    <div class="new-banner-text">
                        <div class="banner-heading">
                            <h1>Get Healthy
                                <br>Local Food Easier.
                            </h1>
                        </div>
                        <div class="search-bar">
                            <div class="mb-3 input-group">
                                <input class="form-control footer-input" aria-labelledby="Search" id="Search" type="text" placeholder="Search the pantry" name="search">
                                <button class="btn btn-outline-secondary footer-button" type="submit">
                                    <!-- <img src="/frontend/images/banner-search-icon.svg" alt=""> -->
                                    <span>
                                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M22.6159 20.8099L16.8201 15.0141C19.6021 11.3482 19.3237 6.08522 15.9802 2.7417C14.2125 0.973758 11.8616 0 9.36105 0C6.8605 0 4.50963 0.973758 2.7417 2.7417C0.973758 4.50963 0 6.8605 0 9.36105C0 11.8613 0.973758 14.2122 2.7417 15.9802C4.5666 17.8053 6.9637 18.7178 9.36105 18.7178C11.3556 18.7178 13.3491 18.0837 15.0141 16.8201L20.8099 22.6159C21.0589 22.8654 21.3861 22.9901 21.7129 22.9901C22.0396 22.9901 22.3668 22.8654 22.6159 22.6159C23.1147 22.1172 23.1147 21.3085 22.6159 20.8099ZM4.5482 14.1742C3.26229 12.8885 2.55445 11.1793 2.55445 9.36105C2.55445 7.54279 3.26229 5.83361 4.5482 4.54795C5.83361 3.26229 7.54305 2.55445 9.36105 2.55445C11.1791 2.55445 12.8885 3.26229 14.1742 4.5482C16.828 7.20203 16.828 11.5203 14.1742 14.1744C11.5201 16.8282 7.20177 16.8277 4.5482 14.1742Z"
                                                fill="#F2EAD4"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="shop-aisle">
                            <div class="shop-aisle-heading">
                                <h2>Shop by Aisle</h2>
                            </div>

                            <div class="shop-aisle-main div-flex">
                                @forelse ($featuredCategories as $category)
                                    <div class="aisle-prod">
                                        <a href="{{ route('products.index', ['categoryId' => [$category->id]]) }}" class="aisle-prod-img">
                                            <img src="{{ $category->getThumbnailUrl() }}" alt="{{ $category->name }}" />
                                        </a>
                                        <div class="aisle-prod-text">
                                            <h3>{{ $category->name }}</h3>
                                        </div>
                                    </div>
                                @empty
                                    <span>{{ trans('catalog.categories.record_not_found') }}</span>
                                @endforelse

                            </div>

                            <div class="text-center aisle-shop-all">
                                <a href="{{ route('products.index') }}" class="are-you-button">Shop All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section>
            @if (! ($bestProducts =getBestProducts())->isEmpty())
                <div class="best-products">
                    <div class="container">
                        <div class="best-products-heading">
                            <h2>What's hot in the pantry?</h2>
                        </div>
                    </div>

                    <div class="best-products-content-main">
                        <div class="best-products-content">
                            <div class="blocks-slider">
                                @foreach ($bestProducts as $product)
                                    <livewire:frontend.home.best-product-card-controller :product="$product" />
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <section>
            <div class="people-pantry-main">
                <div class="container">
                    <div class="people-pantry">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12">
                                <div class="people-pantry-image">
                                    <img class="img-fluid" src="/frontend/images/home-page-people-pantry.jpg" alt="">
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="people-pantry-content">
                                    <h2>The People’s Pantry</h2>
                                    <p>We know you’re a busy bee like us, so we’ll keep it brief. We’re here to connect you
                                        to customers in your area because we believe in the power of local. So, whether
                                        you’re upgrading your side hustle, taking a personal passion to the moon, or just
                                        trying to move a few more units a month, we know how to find the buyers who don’t
                                        even know they want your product yet.
                                        <br><br>
                                        So what do you say? Let’s take what you do and really make it happen!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <section>
        <div class="last-part">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 ">
                        <img class="img-fluid hands" src="/frontend/images/hand.svg" alt="">
                        <div class="are-you">
                            <div class="are-you-heading">
                                <h2>Are you a local farmer, baker, or artisan?</h2>
                                <p>You make it. We’ll help you sell it. <span>: - )</span></p>
                                <div class="button-line">
                                    <a href="{{ route('page', 'sell-now') }}" class="are-you-button">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <livewire:frontend.home.location-popup />
@endsection
