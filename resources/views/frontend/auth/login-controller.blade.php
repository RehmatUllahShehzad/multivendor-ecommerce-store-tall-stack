<div>
    <div class="inner-section">
        <section>
            <div class="auth-portal-main" style="background-image: url('/frontend/images/login.png')">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="auth-portal div-flex">
                                <h1>Log In</h1>
                                <a href="{{ route('register') }}">Don’t have an Account?</a>
                                <form wire:submit.prevent="login">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-form">
                                                <input type="email" aria-labelledby="email" wire:model.defer="email"
                                                    id="email" class="form-control" name="email"
                                                    placeholder="Email" />
                                                @error('email')
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
                                                <input type="password" wire:model.defer="password" class="form-control"
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
                                            <div class="input-form my-4">
                                                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" id="login-button" class="are-you-button">Log In
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
