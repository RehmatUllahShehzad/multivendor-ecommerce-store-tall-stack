<x-slot name="pageTitle">
    {{ __('vendor.profile.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.profile.title') }}
</x-slot>
    <div class="vender-product-management-right position-relative">
        <div class="vendor-profile-add">
            <!-- <div class="vender-right-head div-flex"> -->
            <div class="product-manage-heading toggling-btn-wrap">
                <div class="header-select">
                    <h3>{{ trans('profile.edit.heading') }}</h3>
                </div>
            </div>
            <form wire:submit.prevent="submit">
                <div class="vender-products-edit">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="get-form">
                                <label for="floatingcn">{{ trans('inputs.company_name.label') }}</label>
                                <input wire:model.defer="vendor.company_name" type="text" class="form-control" id="floatingtitle" placeholder="{{ trans('inputs.company_name.label') }}">
                            </div>
                            @error('vendor.company_name')
                                <div class="get-form-error mb-3">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="get-form">
                                <label for="floatingcp">{{ trans('inputs.company_phone.label') }}</label>
                                <input wire:model.defer="vendor.company_phone" type="text" class="form-control number-font mask_us_phone" id="floatingctg" placeholder="{{ trans('inputs.company_phone.label') }}">
                            </div>
                            @error('vendor.company_phone')
                                <div class="get-form-error mb-3">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="get-form">
                                <label for="floatingca">{{ trans('inputs.company_address.label') }}</label>
                                <x-frontend.google-address-autocomplete class="form-control" id="floatingtitle" wire:model.defer='vendor.company_address_components' />
                            </div>
                            @error('vendor.company_address_components')
                                <div class="get-form-error" mb-3>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="get-form">
                                <label for="floatingvb">{{ trans('inputs.vendor_name.label') }}</label>
                                <input wire:model.defer="vendor.vendor_name" type="text" class="form-control" id="floatingtitle" placeholder="{{ trans('inputs.vendor_name.label') }}">
                            </div>
                            @error('vendor.vendor_name')
                                <div class="get-form-error mb-3">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="get-form">
                                <label for="floatingvb">{{ trans('inputs.vendor_bio.label') }}</label>
                                <textarea wire:model.defer="vendor.bio" type="text" rows="4" class="form-control" id="floatingtitle" placeholder="{{ trans('inputs.vendor_bio.label') }}"></textarea>
                            </div>
                            @error('vendor.bio')
                                <div class="get-form-error mb-3">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="vender-nutritional">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                                <h4>Profile Image</h4>
                                <label for="feature-file" id="root-feature" class="feature-upload position-relative flex-wrap d-flex flex-row rounded">
                                    <div class="item-snap">
                                        <div x-data="{
                                            profileImage: @entangle('profileImage')
                                        }" x-show="!profileImage">
                                            <x-fileupload label="<span class='plus'>+</span>" :imagesHolder="null" wire:model="profileImage" :filetypes="['image/*']" :multiple="false" />
                                        </div>

                                        @if ($profileImage)
                                            <div class="feature-upload position-relative flex-wrap d-flex flex-row rounded">
                                                <div class="preview-img"><img class="img-fluid d-block mx-auto h-100" src="{{ $this->profileImagePreview }}" alt=""></div>
                                                <button class="reset-btn" wire:loading.attr="disabled" wire:target="removeImage" wire:click.prevent="removeProfileImage()">X</button>
                                            </div>
                                        @endif
                                    </div>
                                    @error('profileImage')
                                        <div class="error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </label>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                                <h4>Banner Image</h4>
                                <label for="feature-file" id="root-feature" class="feature-upload position-relative flex-wrap d-flex flex-row rounded">
                                    <div class="item-snap">
                                        <div x-data="{
                                            bannerImage: @entangle('bannerImage')
                                        }" x-show="!bannerImage">
                                            <x-fileupload label="<span class='plus'>+</span>" :imagesHolder="null" wire:model="bannerImage" :filetypes="['image/*']" :multiple="false" />
                                        </div>

                                        @if ($bannerImage)
                                            <div class="feature-upload position-relative flex-wrap d-flex flex-row rounded">
                                                <div class="preview-img"><img class="img-fluid d-block mx-auto h-100" src="{{ $this->bannerImagePreview }}" alt=""></div>
                                                <button class="reset-btn" wire:loading.attr="disabled" wire:target="removeImage" wire:click.prevent="removeBannerImage()">X</button>
                                            </div>
                                        @endif
                                    </div>
                                    @error('bannerImage')
                                        <div class="error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="vender-nutritional">
                        <div class="row">
                            <!-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6"> -->
                            <h4>{{ trans('vendor.do_you_deliver_products.label') }}</h4>
                            <div class="vender-profile-add-radio">
                                <div class="addressRadio d-flex align-items-center">
                                    <div class="custom-radio">
                                        <input wire:model.defer="vendor.deliver_products" class="adio-label" type="radio" id="yes" name="deliver_products" value="1">
                                        <label for="yes">Yes</label>
                                    </div>
                                    <div class="custom-radio">
                                        <input wire:model.defer="vendor.deliver_products" class="adio-label" type="radio" id="no" name="deliver_products" value="0" checked>
                                        <label for="no">No (Pick Up Only)</label>
                                    </div>
                                </div>
                                @error('vendor.deliver_products')
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- </div> -->
                            <div class="mt-5 vender-profile-add-delivery d-flex flex-column">
                                <div class="col-lg-4 col-sm-6 col-7">
                                    <div class="get-form">
                                        <label for="floatingvln">{{ trans('inputs.deliver_up_to_max_miles.label') }}</label>
                                        <input wire:model.defer="vendor.deliver_up_to_max_miles" class="form-control number-font" id="floatingtitle" placeholder="00">
                                    </div>
                                    @error('vendor.deliver_up_to_max_miles')
                                        <div class="get-form-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-sm-6 col-7">
                                    <div class="get-form position-relative">
                                        <label for="floatingvln">{{ trans('inputs.express_delivery_rate.label') }}</label>
                                        <input wire:model.defer="vendor.express_delivery_rate" class="form-control number-font" id="floatingtitle" placeholder="00">
                                        <span class="position-absolute">$</span>
                                    </div>
                                    @error('vendor.express_delivery_rate')
                                        <div class="get-form-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-sm-6 col-7">
                                    <div class="get-form position-relative">
                                        <label for="floatingvln">{{ trans('inputs.standard_delivery_rate.label') }}</label>
                                        <input wire:model.defer="vendor.standard_delivery_rate" class="form-control number-font" id="floatingtitle" placeholder="00">
                                        <span class="position-absolute">$</span>
                                    </div>
                                    @error('vendor.standard_delivery_rate')
                                        <div class="get-form-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <div class="submit-btn">
                        <button type="submit" class="checkout-cart-button">{{ trans('inputs.submit.label') }}</button>
                    </div>
                    <div class="preview-btn">
                        <button type="button" onclick="location.href= '{{ route('vendor-profile', $vendor) }}'" class="checkout-cart-button">{{ trans('inputs.preview_profile.label') }}</button>
                    </div>
                </div>
            </form>
        </div>
        @include('frontend.layouts.livewire.loading')
    </div>