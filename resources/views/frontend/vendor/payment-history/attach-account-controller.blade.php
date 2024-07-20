<x-slot name="pageTitle">
    Attach Account
</x-slot>
<x-slot name="pageDescription">
    Attach Account
</x-slot>
<div class="vender-product-management-right">
    <div class="payment-history-wrapper ">
        <div class="product-manage-heading product-review-heading search-setting account-header">
            <div class="header-select">
                <h3>Attach Account</h3>
            </div>
        </div>
        <div class="account-options-wrapper">
            <a href="{{ route('vendor.attach.debit.card') }}" class="account-options">
                <img src="{{ asset('/frontend/images/credit-card.svg') }}" alt="debit card">
                <p>Debit Card</p>
            </a>
            <a href="{{ route('vendor.attach.bank.account') }}" class="account-options">
                <img src="{{ asset('/frontend/images/bank-icon.svg') }}" alt="bank icon">
                <p>Bank Account</p>
            </a>
        </div>
    </div>
</div>
