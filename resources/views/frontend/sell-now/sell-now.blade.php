<div>
    <form wire:submit.prevent="submit">
        <div class="get-started-form">
            <h2>Get Started Today!</h2>
            <div class="apply-form w-100">
                <div class="row">
                    <div class="col-md-6">
                        <div class="get-form">
                            <label for="floatingFname">First Name</label>
                            <input type="text" wire:model.defer="first_name" class="form-control" id="floatingFname"
                                placeholder="First Name">
                        </div>
                        @error('first_name')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="get-form">
                            <label for="floatingLname">Last Name</label>
                            <input type="text" wire:model.defer="last_name" class="form-control" id="floatingLname"
                                placeholder="Last Name">
                        </div>
                        @error('last_name')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="get-form">
                            <label for="floatingEmail">Email</label>
                            <input type="email" wire:model.defer="email" class="form-control" id="floatingEmail"
                                placeholder="joe@email.com">
                        </div>
                        @error('email')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="get-form">
                            <label for="floatingtel">Phone</label>
                            <input type="tel" wire:model.defer="phone" class="form-control mask_us_phone"
                                id="floatingtel" placeholder="Phone">
                        </div>
                        @error('phone')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="get-form">
                            <label for="floatingMessage">Message</label>
                            <textarea rows="8" wire:model.defer="message" class="form-control" id="floatingMessage"></textarea>
                        </div>
                        @error('message')
                            <div class="get-form-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="get-started-form-button">
                <button type="submit" target="submit">Submit
                    <x-button-loading wire:loading wire:target="submit" />
                </button>
            </div>
        </div>
    </form>
</div>
