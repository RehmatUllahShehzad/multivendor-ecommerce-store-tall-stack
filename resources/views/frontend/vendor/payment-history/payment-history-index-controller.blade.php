<x-slot name="pageTitle">
    Payment Histories
</x-slot>
<x-slot name="pageDescription">
    Payment Histories
</x-slot>
<div class="vender-product-management-right">
    <div class="payment-history-wrapper ">
        <div class="product-manage-heading product-review-heading search-setting header-detach">
            <div class="header-select">
                <h3>Payment History</h3>
                <div class="account-btns-wrap">
                    @if ($this->stripeUserInfo && $detailsSubmitted == 'Yes')
                        <div class="account-btns" x-data>
                            <a href="javascript:void(0)" class="attach-btn" data-bs-toggle="modal" @click="$dispatch('showdetachmodal')" data-bs-target="#detatchAccount">Detach account
                                <img src="{{ asset('frontend/images/cross.svg') }}" alt="cross">
                            </a>
                        </div>
                        <div class="account-btns">
                            <a href="javascript:void(0)" class="attach-btn" data-bs-toggle="modal" data-bs-target="#accountInfo">Account Information
                                <img src="{{ asset('frontend/images/circular-tick.svg') }}" alt="tick">
                            </a>
                        </div>
                        @if ($user->balance > 0)
                            <div class="account-btns" x-data>
                                <a href="javascript:void(0)" class="attach-btn" @click="$dispatch('showmodal')" data-bs-target="#withdrawAmount">Withdraw Amount
                                    <img src="{{ asset('frontend/images/withDraw.svg') }}" alt="with draw">
                                </a>
                            </div>
                        @endif
                    @else
                    <div class="account-btns">
                        <a href="{{ route('vendor.attach.account') }}" class="attach-btn">Attach Account
                            <img src="{{ asset('frontend/images/circular-tick.svg') }}" alt="tick">
                        </a>
                    </div>
                @endif
                </div>
            </div>
        </div>
        @if ($user->withdrawAccount && $detailsSubmitted == 'No')
            <div class="alert alert-danger" style="font-size:13px; color:red;">You have Stripe
                Account But Some information is Missing Please Click at Attach Account To fill
                missing Info</div>
        @endif
        <form method="get">
            <div class="search-wrap">
                <div class="search-in">
                    <div class="input-group">
                        <input type="text" wire:model.defer="search" class="form-control number-font" placeholder="Order Number" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                    <div class="error-wrap">
                        <div class="get-form-error d-none">Error</div>
                    </div>
                </div>
                <div class="search-inner">
                    <div class="form-group number-font">
                        <x-lightpick wire:model.defer="dateRange" />
                    </div>
                </div>
                <button class="btn btn-outline-secondary" wire:click="getVendorTransactions" type="button">
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
        <div class="current-balance-wrapper">
            <div class="current-balance">
                <h5>
                    Total Amount Received: <span>${{ number_format($user->balance, 2) ?? 0 }}</span>
                </h5>
            </div>
            <div class="current-balance-table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="19%">Date</th>
                            <th width="22%">Summary</th>
                            <th width="18%">Pending</th>
                            <th width="28%">Available Amount</th>
                            <th width="13%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendorTransactions as $vendorTransaction)
                            <tr>
                                <td>{{ $vendorTransaction->created_at->format('m/d/Y') }}</td>
                                <td>{!! $vendorTransaction->summary !!}</td>
                                <td>
                                    <h4>{{ $vendorTransaction->status == 'pending' && $vendorTransaction->amount > 0 ? number_format($vendorTransaction->amount, 2) : '-' }}
                                    </h4>
                                </td>
                                <td>
                                    <h5>{{ $vendorTransaction->status == 'completed' ? number_format($vendorTransaction->amount, 2) : '-' }}
                                    </h5>
                                </td>
                                <td>
                                    <h6>{{ number_format($vendorTransaction->balance, 2) }}</h6>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    @include('frontend.vendor.message._partials.empty', [
                                        'message' => 'No Vendor Transactions Found',
                                    ])
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center product-pagination">
                {{ $vendorTransactions->onEachSide(1)->links('frontend.layouts.custom-pagination') }}
            </div>
        </div>
    </div>
    <div x-data="{
        showModal: false
    }" @showmodal.window="showModal=true" @hidemodal.window="showModal=false">
        <div class="modal fade theme-modal with-head-modal" :class="showModal ? 'show d-block' : ''" data-bs-backdrop="static" id="withdrawAmount" tabindex="-1" role="dialog" aria-labelledby="withdrawAmount" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Withdraw Amount</h4>
                        <button type="button" class="close" @click="showModal=false" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="fa fa-times"></i>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="add-review-modal-wrap">
                            <p>Are you sure you want withdraw ${{ $user->balance ?? 0 }}.</p>
                        </div>
                        <div class="theme-modal-buttons">
                            <button class="black-btn" wire:click="withdrawAmount">Confirm
                                <x-button-loading wire:loading wire:target="withdrawAmount" />
                            </button>
                            <button class="white-btn" type="button" @click="showModal=false" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade" :class="showModal ? 'show d-block' : 'd-none'"></div>

    </div>
    <div x-data="{
        showDetachModal: false
    }" @showdetachmodal.window="showDetachModal=true" @hidedetachmodal.window="showDetachModal=false">
        <div class="modal fade theme-modal with-head-modal" :class="showModal ? 'show d-block' : ''" data-bs-backdrop="static" id="detatchAccount" tabindex="-1" role="dialog" aria-labelledby="detatchAccount" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Detach Account</h4>
                        <button type="button" class="close" @click="showDetachModal=false" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="fa fa-times"></i>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="add-review-modal-wrap">
                            <p>Are you sure you want to detach your current account.</p>
                        </div>
                        <div class="theme-modal-buttons">
                            <button wire:click="deleteBankAccount" class="black-btn">Confirm
                                <x-button-loading wire:loading wire:target="deleteBankAccount" />
                            </button>

                            <button class="white-btn" @click="showDetachModal=false" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade theme-modal with-head-modal" id="accountInfo" tabindex="-1" role="dialog" aria-labelledby="accountInfoCredit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>View Account</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </span>
                    </button>
                </div>
                @if ($user->withdrawAccount)
                    <div class="modal-body">
                        <div class="acc-info add-review-modal-wrap">
                            <div class="row">
                                @if ($stripeUserInfo['external_accounts']['data'][0]['object'] == 'bank_account')
                                    <div class="col-5 pr-0">
                                        <h5>
                                            Account Holder Name:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p>
                                            {{ $stripeUserInfo['external_accounts']['data'][0]['account_holder_name'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <h5>
                                            IBAN Number:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p><span>
                                            *******{{ $stripeUserInfo['external_accounts']['data'][0]['last4'] ?? '' }}
                                        </span></p>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <h5>
                                            Account Holder Type:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p>
                                            {{ $stripeUserInfo['external_accounts']['data'][0]['account_holder_type'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <h5>
                                            Country:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p>
                                            {{ $stripeUserInfo['external_accounts']['data'][0]['country'] ?? '' }}
                                        </p>
                                    </div>
                                @else
                                    <div class="col-5 pr-0">
                                        <h5>
                                            Name On Card:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p>
                                            {{ $user->withdrawAccount->meta ? $user->withdrawAccount?->getMetaValue('name') : $stripeUserInfo['external_accounts']['data'][0]['account_holder_name'] }}
                                        </p>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <h5>
                                            Card Number:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p>
                                            ********{{ $stripeUserInfo['external_accounts']['data'][0]['last4'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <h5>
                                            Expiry Date:
                                        </h5>
                                    </div>
                                    <div class="col-7 pl-0">
                                        <p>
                                            {{ $user->withdrawAccount->meta ? $user->withdrawAccount?->getMetaValue('exp_month') : '' }}-{{ $user->withdrawAccount->meta ? $user->withdrawAccount?->getMetaValue('exp_year') : '' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="theme-modal-buttons">
                            <button wire:click="deleteBankAccount" wire:loading.class="d-none" class="black-btn">Detach Account</button>
                            <x-button-loading wire:loading wire:target="deleteBankAccount" />
                            <button class="white-btn" type="button" data-bs-dismiss="modal" aria-label="Close">OK</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
