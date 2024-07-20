<div>
    <section>
        <div class="auth-portal-main" style="background-image: url('/frontend/images/signup.png'); height: auto;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="auth-portal vender-signup div-flex">
                            <h1 class="mb-2">Vendor Sign Up</h1>

                            <form wire:submit.prevent="register">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-form">
                                            <input wire:model.defer="company_name" type="text" class="form-control" name="CompanyName"
                                                placeholder="Company Name" />
                                            @error('company_name')
                                                <div class="error">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-form">
                                            <input wire:model.defer="company_phone" type="text" class="form-control number-font mask_us_phone" name="CompanyPhone"
                                                placeholder="Company Phone #" />
                                            @error('company_phone')
                                                <div class="error">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-form">
                                            <x-frontend.google-address-autocomplete class="form-control" name="CompanyAddress" wire:model.defer='company_address_components' />

                                            @error('company_address_components')
                                                <div class="error">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-form">
                                            <input wire:model.defer="vendor_name" type="text" class="form-control" name="vendorName"
                                                placeholder="Vendor Name" />
                                            @error('vendor_name')
                                                <div class="error">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-form">
                                            <textarea wire:model.defer="bio" name="bio" id="" cols="30" rows="10" placeholder="Vendor Bio"></textarea>
                                            @error('bio')
                                                <div class="error">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="are-you-button mt-5">Sign Up
                                    <x-button-loading wire:loading/>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.layouts.livewire.loading')
</div>
