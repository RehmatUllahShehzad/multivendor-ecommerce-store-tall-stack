<div>
    <div class="inner-section">
        <section>
            <div class="auth-portal-main" style="background-image: url('/frontend/images/signup.png')">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="auth-portal div-flex">
                                <h1>Sign Up</h1>
                                <a href="{{ route('login') }}">Already have an Account?</a>
                                <form wire:submit.prevent="register">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-form">
                                                <input type="text" wire:model.defer='user.first_name' class="form-control"
                                                    aria-labelledby="fname" id="fname" name="FirstName"
                                                    placeholder="First Name" />
                                                @error('user.first_name')
                                                    <div class="error">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-form">
                                                <input type="text" wire:model.defer="user.last_name" class="form-control"
                                                    aria-labelledby="lname" id="lname" name="lastName"
                                                    placeholder="Last Name" />
                                                @error('user.last_name')
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
                                                <input type="email" wire:model.defer="user.email" class="form-control"
                                                    aria-labelledby="email" id="email" name="email"
                                                    placeholder="Email" />
                                                @error('user.email')
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
                                                <input type="password" wire:model.defer="password"
                                                    autocomplete="new-password" autocomplete="off" class="form-control"
                                                    aria-labelledby="password" id="password" name="password"
                                                    placeholder="Password" />
                                                @error('password')
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
                                                <input type="password" wire:model.defer="confirmPassword"
                                                    autocomplete="off" class="form-control"
                                                    aria-labelledby="confirm-pwd" id="confirm-pwd" name="repassword"
                                                    placeholder="Confirm Password" />
                                                @error('confirmPassword')
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
    </div>
    @include('frontend.layouts.livewire.loading')
</div>
