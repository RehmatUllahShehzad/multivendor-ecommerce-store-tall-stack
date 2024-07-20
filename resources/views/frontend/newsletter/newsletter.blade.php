<div class="last-list">
    <div class="list">
        <form wire:submit.prevent="submit">
            <div class="list-heading2">
                <h4>Newsletter</h4>
            </div>
            <div class="input-group mb-3">
                <input type="email" wire:model.defer="email" class="form-control footer-input"
                    aria-labelledby="newsletter" id="newsletter" type="email" placeholder="Email">
                @error('email')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
                <button class="btn btn-outline-secondary footer-button" target="submit" type="submit">
                    <x-button-loading wire:loading wire:target="submit" />
                    SUBSCRIBE
                </button>
            </div>
        </form>
    </div>
</div>
