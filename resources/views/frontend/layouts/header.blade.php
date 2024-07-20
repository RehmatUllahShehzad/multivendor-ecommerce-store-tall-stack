<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="header container">
            <div class="header-logo">
                <a href="/">
                    <img class="navbar-brand; header" src="{{ setting('fullImage', '/frontend/images/logo.svg') }}" alt={{ setting('site_title') }}>
                </a>
            </div>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" type="button"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end updation" id="navbarNavAltMarkup"> 
                
                <div class="navbar-nav">  
                    
                    @foreach (getMenu('header') as $item)
                        @if ($item->children->isEmpty())
                            <a class="nav-link" href="{{ url($item->link) }}">{{ $item->title }}</a>
                        @else
                            <li class="nav-item dropdown position-static">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $item->title }}
                                </a>
                                <div class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="menuDrop">
                                                    @foreach ($item->children as $subMenu)
                                                        <a class="dropdown-item" href="{{ url($subMenu->link) }}">
                                                            <div class="drop-img">
                                                                <img class="img-fluid"
                                                                    src="{{ $subMenu->getThumbnailUrl() }}"
                                                                    alt="{{ $subMenu->title }}">
                                                            </div>
                                                            <p>{{ $subMenu->title }}</p>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach

                    @guest
                        <a class="best-products-button header-login-btn d-sm-none" href="{{ route('login') }}" tabindex="0">Log
                            In/Sign Up</a>
                    @endguest     
                    @auth
                        @customer
                            @if (!request()->routeIs('register.vendor'))
                                <a class="best-products-button header-login-btn d-md-none"
                                    href="{{ route('register.vendor') }}"><span>Become a Vendor</span></a>
                            @endif
                        @endCustomer
                        @vendor
                            @if (request()->routeIs('customer*'))
                                <a class="best-products-button header-login-btn d-md-none" href="{{ route('vendor.dashboard') }}">Switch to
                                    Vendor</a>
                            @endif

                            @if (request()->routeIs('vendor*'))
                                <a class="best-products-button header-login-btn d-md-none" href="{{ route('customer.dashboard') }}">Switch
                                    to Buying</a>
                            @endif
                         @endVendor
                    @endauth
                </div>

            </div>

            <div class="header-icons">
                <a class="nav-link" id="header-search" href="#">
                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22.6159 20.8099L16.8201 15.0141C19.6021 11.3482 19.3237 6.08522 15.9802 2.7417C14.2125 0.973758 11.8616 0 9.36105 0C6.8605 0 4.50963 0.973758 2.7417 2.7417C0.973758 4.50963 0 6.8605 0 9.36105C0 11.8613 0.973758 14.2122 2.7417 15.9802C4.5666 17.8053 6.9637 18.7178 9.36105 18.7178C11.3556 18.7178 13.3491 18.0837 15.0141 16.8201L20.8099 22.6159C21.0589 22.8654 21.3861 22.9901 21.7129 22.9901C22.0396 22.9901 22.3668 22.8654 22.6159 22.6159C23.1147 22.1172 23.1147 21.3085 22.6159 20.8099ZM4.5482 14.1742C3.26229 12.8885 2.55445 11.1793 2.55445 9.36105C2.55445 7.54279 3.26229 5.83361 4.5482 4.54795C5.83361 3.26229 7.54305 2.55445 9.36105 2.55445C11.1791 2.55445 12.8885 3.26229 14.1742 4.5482C16.828 7.20203 16.828 11.5203 14.1742 14.1744C11.5201 16.8282 7.20177 16.8277 4.5482 14.1742Z"
                            fill="#F2EAD4" />
                    </svg>
                </a>

                @auth
                    <div class=" dropdown"
                        title="{{ !request()->routeIs('vendor.*') ? Auth::user()->username : Auth::user()->vendor->vendor_name }}">
                        <a class="btn btn-secondary dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            href="#" role="button" aria-expanded="false">
                            <svg width="24" height="23" viewBox="0 0 24 23" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.3937 11.1603C17.4065 10.3477 18.142 9.24072 18.4986 7.9922C18.8553 6.74368 18.8155 5.41523 18.3848 4.19028C17.9541 2.96532 17.1537 1.9043 16.0942 1.15371C15.0347 0.403126 13.7682 0 12.4698 0C11.1713 0 9.90487 0.403126 8.84533 1.15371C7.78579 1.9043 6.98542 2.96532 6.55473 4.19028C6.12403 5.41523 6.08427 6.74368 6.44092 7.9922C6.79757 9.24072 7.53304 10.3477 8.54579 11.1603C6.32972 11.9664 4.41517 13.4345 3.06176 15.3655C1.70835 17.2965 0.981573 19.5971 0.97998 21.9552V23.0002H23.97V21.9552C23.9676 19.5958 23.2393 17.2944 21.8839 15.3632C20.5286 13.432 18.6118 11.9647 16.3937 11.1603ZM8.29499 6.28018C8.29499 5.45346 8.54014 4.6453 8.99944 3.9579C9.45875 3.2705 10.1116 2.73474 10.8754 2.41837C11.6392 2.10199 12.4796 2.01921 13.2905 2.1805C14.1013 2.34179 14.8461 2.73989 15.4307 3.32448C16.0153 3.90906 16.4134 4.65387 16.5747 5.46471C16.736 6.27555 16.6532 7.11601 16.3368 7.8798C16.0204 8.6436 15.4847 9.29643 14.7973 9.75573C14.1099 10.215 13.3017 10.4602 12.475 10.4602C11.3664 10.4602 10.3032 10.0198 9.51928 9.23589C8.73538 8.45199 8.29499 7.38879 8.29499 6.28018ZM3.13268 20.9102C3.38818 18.6097 4.48301 16.4843 6.20765 14.9406C7.93229 13.3969 10.1656 12.5434 12.4802 12.5434C14.7948 12.5434 17.0281 13.3969 18.7528 14.9406C20.4774 16.4843 21.5723 18.6097 21.8277 20.9102H3.13268Z"
                                    fill="#F2EAD4" />
                            </svg>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="{{ route('vendor.dashboard') }}">My Account</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Log
                                    Out</a>
                            </li>
                            

                            <form id="logoutForm" action="{{ route('logout') }}" method="post">
                                @csrf
                            </form>
                        </ul>
                    </div>
                @endauth

                <a class="nav-link header-cart" id="headerCart" href="{{ route('checkout.cart') }}">
                    <svg width="29" height="24" viewBox="0 0 29 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.5334 16.0533L25.0764 2.18059H28.9525V0H23.3828L22.5475 3.27024L0 3.25411L2.39714 16.0532H21.5334V16.0533ZM21.9908 5.45045L19.8398 13.8727H4.20722L2.62723 5.43659L21.9908 5.45045Z"
                            fill="#F2EAD4" />
                        <path
                            d="M18.5484 24C20.4712 24 22.0355 22.4357 22.0355 20.5129C22.0355 18.5901 20.4712 17.0258 18.5484 17.0258H5.41033C3.48754 17.0258 1.92319 18.5901 1.92319 20.5129C1.92319 22.4357 3.4875 24 5.41033 24C7.33317 24 8.89745 22.4357 8.89745 20.5129C8.89745 20.0511 8.80699 19.6101 8.64325 19.2064H15.3155C15.1517 19.6101 15.0613 20.0511 15.0613 20.5129C15.0613 22.4357 16.6256 24 18.5484 24ZM6.71686 20.5129C6.71686 21.2334 6.13076 21.8195 5.41033 21.8195C4.68991 21.8195 4.10378 21.2334 4.10378 20.5129C4.10378 19.7925 4.68987 19.2064 5.41033 19.2064C6.13076 19.2064 6.71686 19.7925 6.71686 20.5129ZM19.855 20.5129C19.855 21.2334 19.2689 21.8195 18.5485 21.8195C17.828 21.8195 17.2419 21.2334 17.2419 20.5129C17.2419 19.7925 17.828 19.2064 18.5485 19.2064C19.2689 19.2064 19.855 19.7925 19.855 20.5129Z"
                            fill="#F2EAD4" />
                    </svg>

                    <livewire:frontend.cart.counter />
                </a>
                @auth
                    @customer
                        @if (!request()->routeIs('register.vendor'))
                            <a class="best-products-button header-login-btn d-none d-md-flex"
                                href="{{ route('register.vendor') }}"><span>Become a Vendor</span></a>
                        @endif
                    @endCustomer

                    @vendor
                        @if (request()->routeIs('customer*'))
                            <a class="best-products-button header-login-btn d-none d-md-flex" href="{{ route('vendor.dashboard') }}">Switch to
                                Vendor</a>
                        @endif

                        @if (request()->routeIs('vendor*'))
                            <a class="best-products-button header-login-btn d-none d-md-flex" href="{{ route('customer.dashboard') }}">Switch
                                to Buying</a>
                        @endif
                    @endVendor
                @endauth

                <!-- Login/SignUp button -->
                @guest
                    <a class="best-products-button header-login-btn d-none d-sm-flex" href="{{ route('login') }}"
                        tabindex="0">Log In/Sign Up</a>
                @endguest

            </div>
        </div>
    </nav>

    <div id="search-show" class="d-none">
        <livewire:frontend.header.search-bar />
        <div id="hide-search" class="position-fixed w-100 h-100 d-block bg-grey" style="top: 0;left:0;background-color: #5f5b5b9e;"></div>
    </div>

</header>
