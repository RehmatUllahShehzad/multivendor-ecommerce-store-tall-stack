<x-slot name="pageTitle">
    Attach Bank Account
</x-slot>
<x-slot name="pageDescription">
    Attach Bank Account
</x-slot>
<div class="vender-product-management-right">
    <div class="product-manage-heading toggling-btn-wrap">
        <div class="header-select">
            <h3>Add Bank Account</h3>
        </div>
    </div>
    <form wire:submit.prevent="submit">
        <div class="managed-products-wrap">
            <div class="vender-products-edit">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="get-form">
                                <label for="accountHolderName">Account Holder Name</label>
                                <input type="text" wire:model.defer="name" wire class="form-control"
                                    id="accountHolderName" placeholder="Account Holder Name">
                            </div>
                            @error('name')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <div class="get-form">
                                <label for="accountNumber">Account Number/IBAN Number</label>
                                <input type="text" wire:model.defer="account_number" class="form-control number-font"
                                    id="accountNumber" placeholder="Account Number/IBAN Number">
                            </div>
                            @error('account_number')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="get-form">
                                <label for="accountHolderType">Account Holder Type</label>
                                <select wire:model.defer="account_type" class="form-control" name=""
                                    id="accountHolderType">
                                    <option value="Account Holder Type">Account Holder Type</option>
                                    <option value="personal">Personal</option>
                                    <option value="business">Business</option>
                                </select>
                            </div>
                            @error('account_type')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="get-form">
                                <label for="country">Country</label>
                                <select wire:model.defer="country" class="form-control" name="" id="country">
                                    <option disabled value="">Choose country</option>
                                    <option value="US">US</option>
                                </select>
                            </div>
                            @error('country')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="checkout-cart-button" type="submit"
                                wire:loading.class="d-none">Submit</button>
                            <x-button-loading wire:loading wire:target="submit" />
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </form>
    @include('frontend.layouts.livewire.loading')
</div>
