<div>
    <div class="row">
        <div class="col-sm-6">
            <div class="float-input-group pb-3">
                <div class="input-group has-validation">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" wire:model.defer="{{ 'address.first_name' }}" class="form-control rounded-0 shadow-none" id="firstName" placeholder="First Name" aria-describedby="firstName" >
                    @error('address.first_name')
                            <div class="get-form-error mt-2">
                                {{ $message }}
                            </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3">
                <div class="input-group has-validation">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" wire:model.defer="{{ 'address.last_name' }}" class="form-control rounded-0 shadow-none" id="lastName" placeholder="Last Name" aria-describedby="lastName" >
                    @error('address.last_name')
                            <div class="get-form-error mt-2">
                                {{ $message }}
                            </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3">
                <div class="input-group has-validation">
                    <label for="phnumber" class="form-label ">Phone Number</label>
                    <input type="text" wire:model.defer="{{ 'address.phone' }}" class="form-control number-font rounded-0 shadow-none mask_us_phone" id="phnumber" placeholder="Phone Number" aria-describedby="phnumber" >
                    @error('address.phone')
                            <div class="get-form-error mt-2">
                                {{ $message }}
                            </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3">
                <div class="input-group has-validation">
                    <label for="ad1" class="form-label">Address 1</label>
                    <input type="text" wire:model.defer="{{ 'address.address_1' }}" class="form-control rounded-0 shadow-none" id="ad1" placeholder="Address 1" aria-describedby="ad1" >
                    @error('address.address_1')
                            <div class="get-form-error mt-2">
                                {{ $message }}
                            </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3">
                <div class="input-group has-validation">
                    <label for="ad2" class="form-label">Address 2</label>
                    <input type="text" wire:model.defer="{{ 'address.address_2' }}" class="form-control rounded-0 shadow-none" id="ad2" placeholder="Address 2" aria-describedby="ad2" >
                    @error('address.address_2')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
            @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3">
                <div class="input-group has-validation">
                    <label for="city" class="form-label">City</label>
                    <input type="text" wire:model.defer="{{ 'address.city' }}" class="form-control rounded-0 shadow-none" id="city" placeholder="City" aria-describedby="city" >
                    @error('address.city')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
            @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3 position-relative">
                <select class="form-select rounded-0" wire:model.defer="{{ 'address.state_id' }}" id="floatingSelectState" aria-label="Floating label select example">
                    <option selected hidden disabled>State</option>
                    @foreach (getStates(['id', 'name'], 233) as $state)
                        <option value="{{ $state->id }}"> {{ $state->name }}
                        </option>
                    @endforeach
                </select>
                <label for="floatingSelectState">State</label>
                @error('address.state_id')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
            @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-input-group pb-3 position-relative">
                <label for="floatingSelectZipcode">Zip Code</label>
                <input type="number" min="0" wire:model.defer="{{ 'address.zip' }}" class="form-control number-font rounded-0 shadow-none" id="city" placeholder="City" aria-describedby="city" >
                @error('address.zip')
                <div class="get-form-error mt-2">
                    {{ $message }}
                </div>
        @enderror
            </div>
        </div>
        <div class="col-sm-12">
            <div class="addressRadio d-flex align-items-center">
                <p class="d-inline-block mt-3 mx-sm-5 mx-2 ms-0 ms-sm-0 text-white">Address Label</p>
                <div class="custom-radio">
                    <input class="adio-label" wire:model.defer="{{ 'address.address_type' }}" value="{{ App\Enums\AddressType::Work->value }}" type="radio" id="work" name="radio-group">
                    <label for="work">Work</label>
                </div>
                <div class="custom-radio">
                    <input class="adio-label" wire:model.defer="{{ 'address.address_type' }}" value="{{ App\Enums\AddressType::Home->value }}" type="radio" id="home" name="radio-group">
                    <label for="home">Home</label>
                </div>
            </div>
            @error('address.address_type')
                <div class="get-form-error mt-2">
                    {{ $message }}
                </div>
        @enderror
        </div>
    </div>
    <div class="modal-footer border-0">
        <button type="submit" class="theme-button">Submit</button>
    </div>
</div>
