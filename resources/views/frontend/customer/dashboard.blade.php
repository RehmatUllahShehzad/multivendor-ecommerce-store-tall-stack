<div class="dash-board-wrap">
    <div class="container">
        <div class="vendor-dash-board">
            <div class="row">
                <div class="col-12">
                    <div class="vendor-dashboard-heading">
                        <h3>Customer Account</h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.orders.index') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/mo.svg" alt="Order List">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Your Orders
                            </h4>
                            <p> Track, return, or buy things
                                again </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.messages') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/ym.svg" alt="Mail box">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Your Messages
                            </h4>
                            <p>
                                View messages to and from People’s Pantry sellers, and buyers
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.payment.index') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/ph.svg" alt="payment book">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Your Payments
                            </h4>
                            <p>
                                Manage payment methods and settings, view all transactions
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.profile') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/mp.svg" alt="Profile Image">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Your Profile
                            </h4>
                            <p>
                                Manage, add, or remove user profiles for personalized experiences
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.addresses.index') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/ad.svg" alt="Product Box">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Addresses
                            </h4>
                            <p>
                                View benefits and payment settings
                            </p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.login.security') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/log.svg" alt="Product Box">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Login & Security
                            </h4>
                            <p>
                                Change Password
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
