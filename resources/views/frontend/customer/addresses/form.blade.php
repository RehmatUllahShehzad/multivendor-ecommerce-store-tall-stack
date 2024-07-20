<div class="row">
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingfn">@lang('global.firstname')</label>
            <input type="text" wire:model.defer="address.first_name" class="form-control" id="floatingfn" placeholder="@lang('global.firstname')">
        </div>
        @error('address.first_name')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingln">@lang('global.lastname')</label>
            <input type="text" wire:model.defer="address.last_name" class="form-control" id="floatingln" placeholder="@lang('global.lastname')">
        </div>
        @error('address.last_name')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingphn">@lang('inputs.phone.label')</label>
            <input type="tel" wire:model.defer="address.phone" class="form-control mask_us_phone" id="floatingphn" placeholder="@lang('inputs.phone.label')">
        </div>
        @error('address.phone')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingadr1">@lang('inputs.address_line_one.label')</label>
            <input type="text" wire:model.defer="address.address_1" class="form-control" id="floatingadr1" placeholder="@lang('inputs.address_line_one.label')">
        </div>
        @error('address.address_1')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingadr2">@lang('inputs.address_line_two.label')</label>
            <input type="text" wire:model.defer="address.address_2" class="form-control" id="floatingadr2" placeholder="@lang('inputs.address_line_two.label')">
        </div>
        @error('address.address_2')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingstate">@lang('inputs.state.label')</label>
            <select class="form-control" wire:model.defer="address.state_id" id="floatingstate">
                @foreach (getStates(['id', 'name'], 233) as $state)
                    <option value="{{ $state->id }}"> {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('address.state_id')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingcity">@lang('inputs.city.label')</label>
            <input type="text" wire:model.defer="address.city" class="form-control" id="floatingcity" placeholder="@lang('inputs.city.label')">
        </div>
        @error('address.city')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-sm-6">
        <div class="get-form">
            <label for="floatingzip">@lang('inputs.postcode.label')</label>
            <input type="number" min="0" wire:model.defer="address.zip" class="form-control number-font" id="floatingzip" placeholder="@lang('inputs.postcode.label')">
        </div>
        @error('address.zip')
            <div class="get-form-error">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="address-label mt-3 mb-3">
        <div class="row align-items-baseline">
            <div class="col-sm-3 col-5">
                <h4>@lang('inputs.address.label')</h4>
            </div>
            <div class="col-sm-9 col-7">
                <div class="vender-profile-add-radio">
                    <div class="addressRadio d-flex align-items-center">
                        <div class="custom-radio">
                            <input class="adio-label" wire:model.defer="address.address_type" value="{{ App\Enums\AddressType::Work->value }}" type="radio" id="yes" name="radio-group">
                            <label for="yes">@lang('inputs.work.label')</label>
                        </div>
                        <div class="custom-radio">
                            <input class="adio-label" wire:model.defer="address.address_type" value="{{ App\Enums\AddressType::Home->value }}" type="radio" id="no" name="radio-group">
                            <label for="no">@lang('inputs.home.label')</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @error('address.address_type')
            <div class="get-form-error mt-3">
                <div class="get-form-error">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="col-md-12">
        <label class="checkout-checkbox mt-3 mb-4">
            <input type="checkbox" wire:model="isPrimary">
            <span class="checkmark"></span>
            @lang('customer.addresses.make_primary')
        </label>
    </div>

    <div class="col-md-12 mt-3">
        <button type="submit" class="checkout-cart-button">
            {{ $this->address->exists ? __('customer.addresses.update.btn') : __('customer.addresses.create.btn') }}
            <x-button-loading wire:loading wire:target="submit" />
        </button>
    </div>
</div>
