<x-slot name="title">
    Vendor Dashboard
</x-slot>
<div class="dash-board-wrap">
    <div class="container">
        <div class="vendor-dash-board">
            <div class="row">
                <div class="col-12">
                    <div class="vendor-dashboard-heading">
                        <h3>Vendor Account</h3>
                        <!-- <a href="" class="verified">Verified</a> -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('vendor.product.index') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/pm.svg" alt="Profile Image">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Product Management
                            </h4>
                            <p>
                                Manage, add, or remove
                                product
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('vendor.reviews') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/pr.svg" alt="Product Box">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Product Reviews
                            </h4>
                            <p>
                                Approve/Reject Customer
                                Reviews
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('vendor.orders') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/mo.svg" alt="Order List">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Your Orders
                            </h4>
                            <p>
                                Track, return, or buy things
                                again
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('vendor.messages') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/ym.svg" alt="Mail box">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Your Messages
                            </h4>
                            <p>
                                View messages to and from
                                sellers, and buyers
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('vendor.payment.history.index') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="/frontend/images/ph.svg" alt="payment book">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                Payment History
                            </h4>
                            <p>
                                View benefits and payment
                                settings
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('vendor.profile') }}" class="vendor-dash-board-content">
                        <div class="vendor-image">
                            <img src="{{ asset('/frontend/images/mp.svg') }}" alt="Profile Image">
                        </div>
                        <div class="vendor-profile-detail">
                            <h4>
                                My Profile
                            </h4>
                            <p>
                                Manage, add, or remove
                                user profiles for personalized experiences
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
