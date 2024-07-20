@extends('frontend.layouts.master')

@section('meta_title', 'Vendor Profile')
@section('meta_description', '')
@section('page')
    <div class="inner-section">
        <div class="vendor-profile-main">
            <section>
                <div class="whats-new-banner"
                    style="background-image: url('{{ asset('frontend/images/product-listing.png')}}'), linear-gradient(rgba(0,0,0,0.15),rgba(0,0,0,0.15));">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="whats-new-banner-heading">
                                    <!-- <h1>Our Products</h1> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">
                    <div class="row">
                        
                        <div class="col-12">
                            <div class="vendor-profile">
                                <div class="vendor-profile-img">
                                    <img src="{{ asset('frontend/images/vendor-profile.png')}}" alt="">
                                </div>
                                <div class="vendor-profile-text">
                                    <h4>{{$vendor->vendor_name ?? ''}}</h4>                                   
                                    <p>{{$vendor->bio ?? ''}}</p>                                   
                                </div>
                            </div>

                            <div class="product-listing-search-main div-flex">
                                <div class="product-listing-search">
                                    <select name="search-filter" id="search-filter">
                                        <option value="">Search</option>
                                        <option value="">Search</option>
                                        <option value="">Search</option>
                                        <option value="">Search</option>
                                    </select>

                                </div>
                                <div class="input-group">
                                    <input class="form-control" type="text" aria-labelledby="look" id="look"
                                        placeholder="What are you looking for?">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.5 1C8.99246 1 9.48018 1.04804 9.96318 1.14411C10.4462 1.24018 10.9152 1.38245 11.3701 1.5709C11.8251 1.75936 12.2573 1.99038 12.6668 2.26398C13.0762 2.53757 13.4551 2.84848 13.8033 3.1967C14.1515 3.54492 14.4624 3.92376 14.736 4.33322C15.0096 4.74269 15.2406 5.1749 15.4291 5.62987C15.6176 6.08484 15.7598 6.55383 15.8559 7.03682C15.952 7.51982 16 8.00754 16 8.5C16 8.99246 15.952 9.48018 15.8559 9.96318C15.7598 10.4462 15.6176 10.9152 15.4291 11.3701C15.2406 11.8251 15.0096 12.2573 14.736 12.6668C14.4624 13.0762 14.1515 13.4551 13.8033 13.8033C13.4551 14.1515 13.0762 14.4624 12.6668 14.736C12.2573 15.0096 11.8251 15.2406 11.3701 15.4291C10.9152 15.6176 10.4462 15.7598 9.96318 15.8559C9.48018 15.952 8.99246 16 8.5 16C8.00754 16 7.51982 15.952 7.03682 15.8559C6.55383 15.7598 6.08484 15.6176 5.62987 15.4291C5.1749 15.2406 4.74269 15.0096 4.33322 14.736C3.92376 14.4624 3.54492 14.1515 3.1967 13.8033C2.84848 13.4551 2.53757 13.0762 2.26398 12.6668C1.99038 12.2573 1.75936 11.8251 1.5709 11.3701C1.38245 10.9152 1.24018 10.4462 1.14411 9.96318C1.04804 9.48018 1 8.99246 1 8.5C1 8.00754 1.04804 7.51982 1.14411 7.03682C1.24018 6.55383 1.38245 6.08484 1.5709 5.62987C1.75936 5.1749 1.99038 4.74269 2.26398 4.33322C2.53757 3.92376 2.84848 3.54492 3.1967 3.1967C3.54492 2.84848 3.92376 2.53757 4.33322 2.26398C4.74269 1.99038 5.1749 1.75936 5.62987 1.5709C6.08484 1.38245 6.55383 1.24018 7.03682 1.14411C7.51982 1.04804 8.00754 1 8.5 1Z"
                                                stroke="#3B5540" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M18.1984 18.0001L14.042 13.8438" stroke="#3B5540"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Search
                                    </button>
                                </div>
                            </div>

                            <div class="product-card-main div-flex">
                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you1.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Veggie Gals Salad</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>
                                        <p>$3.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button id="minus">−</button>
                                                <input type="text" value="01" id="countNew" disabled>
                                                <button id="plus">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you2.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Craft Poppcorn</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$6.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you3.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Bad Apple Orchard Cider</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$10.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you1.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Veggie Gals Salad</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>
                                        <p>$3.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button id="minus">−</button>
                                                <input type="text" value="01" id="countNew" disabled>
                                                <button id="plus">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you2.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Craft Poppcorn</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$6.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you3.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Bad Apple Orchard Cider</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$10.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you1.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Veggie Gals Salad</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>
                                        <p>$3.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button id="minus">−</button>
                                                <input type="text" value="01" id="countNew" disabled>
                                                <button id="plus">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you2.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Craft Poppcorn</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$6.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you3.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Bad Apple Orchard Cider</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$10.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you1.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Veggie Gals Salad</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>
                                        <p>$3.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button id="minus">−</button>
                                                <input type="text" value="01" id="countNew" disabled>
                                                <button id="plus">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you2.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Craft Poppcorn</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$6.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="new-near-you-block">
                                    <a href="product-detail.php">
                                        <img src="{{ asset('frontend/images/new-near-you3.png')}}" alt="product">
                                    </a>
                                    <div class="product-card-text">
                                        <h4>Bad Apple Orchard Cider</h4>
                                        <a href="vendor-profile.php" class="product-card-description producer">Vendor Name
                                            Here</a>

                                        <p>$10.50</p>
                                        <span>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                            <i class="fas fa-star stars star-active"></i>
                                        </span>

                                        <div class="buttons-of-new-near-you">
                                            <div class="new-near-you-counter">
                                                <button tabindex="0">−</button>
                                                <input type="text" value="01" disabled="" tabindex="0">
                                                <button tabindex="0">+</button>
                                            </div>
                                            <a href="cart.php" class="new-near-you-button">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="text-center product-pagination">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item"><a class="page-link new-near-you-button">Prev Page</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3...</a></li>
                                    <li class="page-item"><a class="page-link" href="#">12</a></li>
                                    <li class="page-item"> <a class="page-link new-near-you-button" href="#">Next
                                            Page</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
