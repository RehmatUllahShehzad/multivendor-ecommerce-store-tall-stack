<div>
    <div class="inner-section">
        <section>
            <div class="auth-portal-main" style="background-image: url('/frontend/images/login.png')">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="auth-portal forgot-password div-flex">
                                <h1>Forgot Your Password</h1>
                                <p>Don’t worry! Just fill in your email and <br /> we’ll send you a link to reset your
                                    password.</p>

                                <form wire:submit.prevent="sendPasswordResetLink">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-form">
                                                <input type="email" wire:model.defer="email" aria-labelledby="Email"
                                                    id="Email" class="form-control" name="email"
                                                    placeholder="Email" />
                                                @error('email')
                                                    <div class="error">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="are-you-button mt-4">Reset-Password
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
