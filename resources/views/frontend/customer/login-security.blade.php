<x-slot name="pageTitle">
    {{ trans('global.login.security.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ trans('global.login.security.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="product-manage-heading toggling-btn-wrap">
        <div class="header-select">
            <h3>LOGIN & SECURITY</h3>
        </div>
    </div>
    <div class="managed-products-wrap">
        <div class="vender-products-edit security-wrap">
            <div class="row">
                <form wire:submit.prevent="submit">
                    <div class="col-lg-6 col-md-12 col-sm-6">
                        <div class="get-form">
                            <label for="floatingold-pwd">Current Password</label>
                            <input wire:model.defer="current_password" type="password" class="form-control" id="NewPassword" placeholder="Current Password">
                            <i d-toggle="#NewPassword" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                        </div>
                        @error('current_password')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-lg-6 col-md-12 col-sm-6">
                        <div class="get-form">
                            <label for="floatingn-pwd">New Password</label>
                            <input wire:model.defer="new_password" type="password" class="form-control" id="newPassword" placeholder="New Password">
                            <i d-toggle="#newPassword" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                        </div>
                        @error('new_password')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-lg-6 col-md-12 col-sm-6">
                        <div class="get-form">
                            <label for="floatingcfrm-pwd">Confirm Password</label>
                            <input wire:model.defer="confirm_password" type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                            <i d-toggle="#confirmPassword" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                        </div>
                        @error('confirm_password')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6"></div>

                    <div class="mt-3 col-md-12">
                        <button type="submit" class="checkout-cart-button">Save
                            <x-button-loading wire:loading />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('frontend.layouts.livewire.loading')
    
</div>
