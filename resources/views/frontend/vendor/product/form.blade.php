<div>
    <!-- <div class="vender-right-head div-flex"> -->
    <div class="product-manage-heading toggling-btn-wrap">
        <div class="header-select">
            <h3>{{ $product->exists ? __('vendor.product.edit.title') : __('vendor.product.create.title') }}</h3>
        </div>
    </div>
    <div class="vender-products-edit">
        <div class="vender-products-edit">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="get-form">
                        <label for="floatingtitle">Title</label>
                        <input class="form-control" id="floatingtitle" type="text" wire:model.defer="product.title" placeholder="Title">
                    </div>
                    @error('product.title')
                        <div class="get-form-error mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="get-form add-item-select-form" wire:ignore>
                        <label class="position-absolute select-label" for="floatingtitle">Category</label>
                        <x-select2 wire:model.defer="selectedCategories" :options="$this->categories" />
                    </div>
                    @error('selectedCategories')
                        <div class="get-form-error mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        <div class="vender-product-description">
            <div class="vender-product-description-block">
                <h4>Description</h4>
                <x-richtext wire:model.defer="product.description" :initialValue="$product->description" />
                @error('product.description')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="vender-product-description-block">
                <h4>Attributes</h4>
                <x-richtext wire:model.defer="product.attributes" :initialValue="$product->attributes" />
                @error('product.attributes')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="vender-product-description-block">
                <h4>Ingredients</h4>
                <x-richtext wire:model.defer="product.ingredients" :initialValue="$product->ingredients" />
                @error('product.ingredients')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="vender-nutritional">
        <h4>Nutritional Information</h4>
        @foreach ($nutritionInputs as $key => $input)
            <div class="nutrition-info-item">
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="input-group">
                                <label class="form-label" for="country-type">Nutrition</label>
                                <select class="country-select" id="input_{{ $key }}_nutrition" wire:model.defer="nutritionInputs.{{ $key }}.nutrition_id">
                                    <option value="" disabled>Choose Nutrition
                                    </option>
                                    @foreach ($this->nutritions as $nutrition)
                                        <option value="{{ $nutrition->id }}" {{ old('nutrition_id') == $nutrition->id ? 'selected' : '' }}>
                                            {{ $nutrition->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('nutritionInputs.' . $key . '.nutrition_id')
                                <div class="get-form-error mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                            <div class="input-group">
                                <label class="form-label" for="country-type">Value</label>
                                <input class="form-control number-font" id="input_{{ $key }}_value" type="text" wire:model.defer="nutritionInputs.{{ $key }}.value" placeholder="80">
                            </div>
                            @error('nutritionInputs.' . $key . '.value')
                                <div class="get-form-error mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                            <div class="input-group">
                                <label class="form-label" for="country-type">Unit</label>
                                <select class="country-select" id="input_{{ $key }}_unit" wire:model.defer="nutritionInputs.{{ $key }}.unit_id">
                                    <option value="" disabled>Choose Unit</option>
                                    @foreach ($this->units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('nutrition_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('nutritionInputs.' . $key . '.unit_id')
                                <div class="get-form-error mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @if ($key > 0)
                            <div class="col-lg-1 col-md-1 col-sm-1 col-6">
                                <div class="delete-nutrition">
                                    <button type="button" wire:click="removeNutritionInput({{ $key }}) class="delete">
                                        <img src="{{ asset('/frontend/images/trash.svg') }}" alt="">
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        <div class="attr-button mt-4">
            <button class="theme-button" type="button" wire:click="addNutritionInput">Add Nutrition Info</button>
        </div>
    </div>

    <div class="vender-nutritional sale-unit">
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 pe-xl-0 me-xl-4 me-lg-3">
                <h4>Available Quantity</h4>
                <div class="get-form get-input-from">
                    <input class="form-control number-font number-field ps-0" id="floatingtitle" type="text" wire:model.defer="product.available_quantity" placeholder="0">
                </div>
                @error('product.available_quantity')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-lg-3 col-md-5 col-sm-4 col-6 me-lg-3">
                <h4>Sale Unit</h4>

                <div class="input-group">
                    <select class="country-select" wire:model.defer="product.unit_id">
                        <option value="">Choose Sale Unit</option>
                        @foreach ($this->units as $unit)
                            <option value="{{ $unit->id }}">
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('product.unit_id')
                    <div class="get-form-error mt-3">
                        {{ __('vendor.product.create.unit.validation.required') }}
                    </div>
                @enderror

            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                <h4>Price</h4>
                <div class="get-form get-input-from">
                    <p class="doller-sign number-font">$</p>
                    <input class="form-control number-font" id="floatingtitle" wire:model.defer="product.price" placeholder="00.00">
                </div>
                @error('product.price')
                    <div class="get-form-error mt-2 mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="vender-nutritional">
        <x-image-manager :existing="$images" :maxFileSize="3" :maxFiles="5" :multiple="false" model="imageUploadQueue" :filetypes="['image/*']" />
    </div>

    <div class="vender-nutritional">
        <h4>Dietary Restrictions</h4>
        @foreach ($this->dietaryRestrictions as $key => $dietaryRestriction)
            <div class="row">
                <div class="col-md-12">
                    <label class="checkout-checkbox">
                        <input type="checkbox" value="{{ $key }}" wire:model.defer="selectedDietaryRestrictions">
                        <span class="checkmark"></span>
                        {{ $dietaryRestriction }}
                    </label>
                </div>
            </div>
        @endforeach

    </div>

    <div class="vender-nutritional">
        <div class="row">
            <h4>Status</h4>
            <div class="vender-profile-add-radio">
                <div class="addressRadio d-flex align-items-center">
                    <div class="custom-radio">
                        <input class="adio-label" id="yes" name="is_published" type="radio" value="1" wire:model.defer="product.is_published">
                        <label for="yes">Publish</label>
                    </div>
                    <div class="custom-radio">
                        <input class="adio-label" id="no" name="is_published" type="radio" value="0" wire:model.defer="product.is_published">
                        <label for="no">Un-Publish</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="submit-btn">
        <button class="checkout-cart-button" type="submit">
            Submit
            <x-button-loading wire:loading />
        </button>
    </div>
    @include('frontend.layouts.livewire.loading')

</div>



   

