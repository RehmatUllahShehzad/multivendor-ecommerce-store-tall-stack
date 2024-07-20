<div class="row">
    <h4>{{ __('global.image-manager.heading') }}</h4>
    @foreach ($this->images as $image)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6" wire:key="image_{{ $image['sort_key'] }}">
            <div class="feature-upload position-relative flex-wrap d-flex flex-row rounded item-snap">
                <img src="{{ $image['original'] }}" class="img-fluid d-block mx-auto h-100" alt="Avatar">

                <label class="checkout-checkbox position-absolute" style="bottom: 0; right:0;" title="Select Primary">
                    <input wire:click.prevent="setPrimary('{{ $loop->index }}')" @if ($image['primary'] ?? true) checked @endif value="1" type="checkbox">
                    <span class="checkmark"></span>
                </label>

                <button class="reset-btn" type="button" wire:loading.attr="disabled" wire:target="removeImage" wire:click.prevent="removeImage('{{ $image['sort_key'] }}')">x</button>
            </div>
        </div>
    @endforeach
    @if (count($images) < $maxFiles)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
            <label id="root-feature" class="feature-upload position-relative flex-wrap d-flex flex-row rounded">
                <div class="item-snap">
                    <x-fileupload label="<span class='plus'>+</span>" wire:model="{{ $wireModel }}" imagesHolder="images" :filetypes="$filetypes" :maxFiles="$maxFiles" :maxFileSize="$maxFileSize" :multiple="$multiple" />
                </div>
                @error('images')
                    <div class="get-form-error mt-2 mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </label>
        </div>
    @endif
</div>
