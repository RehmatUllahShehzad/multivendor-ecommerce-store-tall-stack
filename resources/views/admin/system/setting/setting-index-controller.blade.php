<x-slot name="pageTitle">
    {{ __('settings.title') }}
</x-slot>
<div>
    <form action="submit" method="POST" wire:submit.prevent="submit">
        <div class="flex flex-col">
            <div class="col-span-12 space-y-4">
                <x-admin.components.card heading="">
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.components.input.group label="{{ __('settings.site.title.label') }}" for="site_meta" :error="$errors->first('settings.site_title')">
                            <x-admin.components.input.text wire:model.defer="settings.site_title" name="site_title" id="site_title" :error="$errors->first('settings.site_title')" />
                        </x-admin.components.input.group>
                        <x-admin.components.input.group label="{{ __('settings.meta.tag.label') }}" for="meta_tag" :error="$errors->first('settings.meta_tag')">
                            <x-admin.components.input.text wire:model.defer="settings.meta_tag" name="meta_tag" id="meta_tag" :error="$errors->first('settings.meta_tag')" />
                        </x-admin.components.input.group>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.components.input.group label="{{ __('settings.contact.email.label') }}" for="Contact us email" :error="$errors->first('settings.contact_us_email')">
                            <x-admin.components.input.text wire:model.defer="settings.contact_us_email" name="contact_us_email" id="contact_us_email" :error="$errors->first('settings.contact_us_email')" />
                        </x-admin.components.input.group>
                        <x-admin.components.input.group label="{{ __('inputs.phone.label') }}" for="phone" :error="$errors->first('settings.phone')">
                            <x-admin.components.input.text wire:model.defer="settings.phone" id="phone" :error="$errors->first('settings.phone')" />
                        </x-admin.components.input.group>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.components.input.group label="Address" for="address" :error="$errors->first('settings.address')">
                            <x-admin.components.input.text wire:model.defer="settings.address" id="address" :error="$errors->first('settings.address')" />
                        </x-admin.components.input.group>
                        <x-admin.components.input.group label="{{ __('settings.copyright.label') }}" for="copyright_text" :error="$errors->first('settings.copyright_text')">
                            <x-admin.components.input.text wire:model.defer="settings.copyright_text" id="copyright_text" :error="$errors->first('settings.copyright_text')" />
                        </x-admin.components.input.group>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.components.input.group label="{{ __('settings.facebook.url.label') }}" for="facebook_url" :error="$errors->first('settings.facebook_url')">
                            <x-admin.components.input.text wire:model.defer="settings.facebook_url" id="facebook_url" :error="$errors->first('settings.facebook_url')" />
                        </x-admin.components.input.group>
                        <x-admin.components.input.group label="{{ __('settings.twitter.url.label') }}" for="twitter_url" :error="$errors->first('settings.twitter_url')">
                            <x-admin.components.input.text wire:model.defer="settings.twitter_url" id="twitter_url" :error="$errors->first('settings.twitter_url')" />
                        </x-admin.components.input.group>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.components.input.group label="{{ __('settings.instagram.url.label') }}" for="instagram_url" :error="$errors->first('settings.instagram_url')">
                            <x-admin.components.input.text wire:model.defer="settings.instagram_url" id="instagram_url" :error="$errors->first('settings.instagram_url')" />
                        </x-admin.components.input.group>
                        <x-admin.components.input.group label="{{ __('settings.informational.email.label') }}" for="information_email" :error="$errors->first('settings.information_email')">
                            <x-admin.components.input.text wire:model.defer="settings.information_email" id="information_email" :error="$errors->first('settings.information_email')" />
                        </x-admin.components.input.group>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.components.input.group label="{{ __('customer.orders.service.fee') }}" for="service_fee" :error="$errors->first('settings.service_fee')">
                            <x-admin.components.input.text wire:model.defer="settings.service_fee" id="service_fee" :error="$errors->first('settings.service_fee')" />
                        </x-admin.components.input.group>
                        <x-admin.components.input.group label="{{ __('settings.order.processing.time.label') }}" for="order_payment_processing_time" :error="$errors->first('settings.order_payment_processing_time')">
                            <x-admin.components.input.text wire:model.defer="settings.order_payment_processing_time" id="order_payment_processing_time" :error="$errors->first('settings.order_payment_processing_time')" />
                        </x-admin.components.input.group>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="pb-2">{{ __('settings.small.image.label') }}</h4>
                            <div x-data="{
                                smallImage: @entangle('smallImage')
                            }" x-show="!smallImage">
                                <x-fileupload label="<span class='plus'>+</span>" :imagesHolder="null" wire:model="smallImage" :filetypes="['image/*']" :multiple="false" />
                            </div>

                            @if ($smallImage)
                                <div class="feature-upload relative flex-wrap d-flex flex-row rounded border p-2">
                                    <div class="preview-img">
                                        <img class="img-fluid d-block mx-auto h-[150px]" src="{{ $this->smallImagePreview }}" alt="">
                                    </div>
                                    <button wire:loading.attr="disabled" class="inline-flex absolute top-2 right-2 justify-center items-center w-6 h-6 text-xs opacity-80 font-bold text-white bg-gray-700 rounded-full cursor-pointer" wire:target="removeImage" wire:click.prevent="removeSmallImage()">
                                        x
                                    </button>
                                </div>
                            @endif
                            @error('smallImage')
                                <div class="error">
                                    <p class="text-sm text-red-600"> {{ $message }} </p>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <h4 class="pb-2">{{ __('settings.full.image.label') }}</h4>
                            <div x-data="{
                                fullImage: @entangle('fullImage')
                            }" x-show="!fullImage">
                                <x-fileupload label="<span class='plus'>+</span>" :imagesHolder="null" wire:model="fullImage" :filetypes="['image/*']" :multiple="false" />
                            </div>

                            @if ($fullImage)
                                <div class="feature-upload relative flex-wrap d-flex flex-row rounded border p-2">
                                    <div class="preview-img">
                                        <img class="img-fluid d-block mx-auto h-[150px]" src="{{ $this->fullImagePreview }}" alt="">
                                    </div>
                                    <button wire:loading.attr="disabled" class="inline-flex absolute top-2 right-2 justify-center items-center w-6 h-6 text-xs opacity-80 font-bold text-white bg-gray-700 rounded-full cursor-pointer" wire:target="removeImage" wire:click.prevent="removeFullImage()">
                                        x
                                    </button>
                                </div>
                            @endif

                            @error('fullImage')
                                <div class="error">
                                    <p class="text-sm text-red-600"> {{ $message }} </p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </x-admin.components.card>
            </div>
            <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit
                </button>
            </div>
        </div>

</div>
</form>
</div>
