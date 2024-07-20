<footer>
    <div class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="footer-logo">
                            <a href="/">
                                <img src="/frontend/images/footer-logo.svg" alt="People's Pantry">
                            </a>
                        </div>
                        <div class="button-line text-center text-sm-start">
                            <a href="{{ route('page', 'sell-now') }}" class="are-you-button">Get Started</a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-6  list1">

                        <div class="list-heading">
                            <h4>Shop</h4>
                        </div>

                        <div class="list">
                            <ul>
                                @foreach (getMenu('footer-shop') as $item)
                                    <li>
                                        <a href="{{ url($item->link) }}">{{ $item->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-2 col-sm-6 list2">

                        <div class="list-heading">
                            <h4>Learn</h4>
                        </div>
                        <div class="list">
                            <ul>
                                @foreach (getMenu('footer-learn') as $item)
                                    <li>
                                        <a href="{{ url($item->link) }}">{{ $item->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-12">

                        <div class="footer-listing">
                            <div class="last-list">
                                <div class="list-heading">
                                    <h4>Social</h4>
                                </div>

                                <div class="list">
                                    <ul class="social-icons">
                                        <li><a class="instagram" href="{{ setting('instagram_url') }}"><i class="fab fa-instagram"></i> <span class="d-none">1</span></a></li>
                                        <li><a class="facebook" href="{{ setting('facebook_url') }}"><i class="fab fa-facebook"></i> <span class="d-none">1</span></a></li>
                                        <li><a class="twitter" href="{{ setting('twitter_url') }}"><i class="fab fa-twitter"></i> <span class="d-none">1</span></a></li>
                                    </ul>
                                </div>
                            </div>

                            <livewire:frontend.newsletter.newsletter />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-line">
        </div>
        <div class="copyright">
            <p>
                © <span> {{ now()->year }} </span>
                {{ setting('copyright_text') }}
            </p>
        </div>
    </div>
</footer>
