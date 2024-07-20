<x-slot name="pageTitle">
    {{ trans('global.profile.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ trans('global.profile.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="product-manage-heading toggling-btn-wrap">
        <div class="header-select">
            <h3>My Profile</h3>
        </div>
    </div>
    <div class="managed-products-wrap">
        <div class="vender-products-edit">
            <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="col-md-12">
                        <div class="get-form">
                            <label for="floatingUsername">Username</label>
                            <input wire:model.defer="user.username" type="text" class="form-control"
                                id="floatingUsername" placeholder="Username">
                        </div>
                        @error('user.username')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                        <div style="margin: -5px 0 12px">This username will only be used if you are
                            posting review on site.</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="get-form">
                            <label for="floatingfn">First Name</label>
                            <input wire:model.defer="user.first_name" type="text" class="form-control"
                                id="floatingfn" placeholder="First Name">
                        </div>
                        @error('user.first_name')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="get-form">
                            <label for="floatingln">Last Name</label>
                            <input wire:model.defer="user.last_name" type="text" class="form-control"
                                id="floatingln" placeholder="Last Name">
                        </div>
                        @error('user.last_name')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="get-form">
                            <label for="floatingemail">Email</label>
                            <input readonly value="{{ $this->user->email }}" type="email" class="form-control"
                                id="floatingemail" placeholder="joe@email.com">
                        </div>
                        <div class="get-form-error d-none">Error</div>
                    </div>
                    <div class="mt-3 col-md-12">
                        <button type="submit" class="checkout-cart-button">Save
                            <x-button-loading wire:loading/>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('frontend.layouts.livewire.loading')
</div>
