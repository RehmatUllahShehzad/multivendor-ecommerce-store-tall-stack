<div class="flex items-center space-x-4">

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
        <div class="sm:px-12 lg:px-0 lg:col-span-12">
            <div class="space-y-6">
                <div id="identifiers">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <header>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Basic Information
                                </h3>
                            </header>

                            <div class="space-y-4">
                                <div>
                                    <x-admin.components.input.group for="title" label="{{ __('inputs.title') }}" :error="$errors->first('product.title')">
                                        <x-admin.components.input.text id="title" name="title" wire:model.defer="product.title" :error="$errors->first('product.title')" />
                                    </x-admin.components.input.group>
                                </div>
                                <div>
                                    <label class="flex items-center block text-sm font-medium text-gray-700" for="sku">
                                        <span class="block"></span>
                                        <span class="block">Description</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <x-admin.components.input.richtext wire:model.defer="product.description" :initialValue="$product->description" />
                                    </div>
                                    @error('product.description')
                                        <div class="space-y-1 text-center">
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="flex items-center block text-sm font-medium text-gray-700" for="sku">
                                        <span class="block"></span>
                                        <span class="block">Attributes</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <x-admin.components.input.richtext wire:model.defer="product.attributes" :initialValue="$product->attributes" />
                                    </div>
                                </div>
                                <div>
                                    <label class="flex items-center block text-sm font-medium text-gray-700" for="sku">
                                        <span class="block"></span>
                                        <span class="block">Ingredients</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <x-admin.components.input.richtext wire:model.defer="product.ingredients" :initialValue="$product->ingredients" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="featured">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <div>
                                <x-admin.components.input.group for="name" label="Featured" :error="$errors->first('product.is_featured')">
                                    <x-admin.components.input.toggle id="value" name="name" wire:model.defer="product.is_featured" :error="$errors->first('product.is_featured')" />
                                </x-admin.components.input.group>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nutritions">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <header>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Nutritional Information
                                </h3>
                            </header>
                            @foreach ($nutritionInputs as $key => $input)
                                <div class="grid grid-cols-10 gap-4">
                                    <div class="col-span-3">
                                        <x-admin.components.input.group for="name" label="Nutrition" :error="$errors->first('nutritionInputs.' . $key . '.nutrition_id')">
                                            <x-admin.components.input.select id="input_{{ $key }}_nutrition" wire:model.defer="nutritionInputs.{{ $key }}.nutrition_id">
                                                <option value="" disabled>Choose Nutrition
                                                </option>
                                                @foreach ($this->nutritions as $nutrition)
                                                    <option value="{{ $nutrition->id }}">{{ $nutrition->name }}</option>
                                                @endforeach
                                            </x-admin.components.input.select>
                                        </x-admin.components.input.group>
                                    </div>
                                    <div class="col-span-3">
                                        <x-admin.components.input.group for="name" label="Value" :error="$errors->first('nutritionInputs.' . $key . '.value')">
                                            <x-admin.components.input.text id="input_{{ $key }}_value" name="name" placeholder="Value" wire:model.defer="nutritionInputs.{{ $key }}.value" :error="$errors->first('nutritionInputs.' . $key . '.value')" />
                                        </x-admin.components.input.group>
                                    </div>
                                    <div class="col-span-3">
                                        <x-admin.components.input.group for="name" label="Unit" :error="$errors->first('nutritionInputs.' . $key . '.unit_id')">
                                            <x-admin.components.input.select id="input_{{ $key }}_unit" wire:model.defer="nutritionInputs.{{ $key }}.unit_id">
                                                <option value="" disabled>Choose Unit
                                                </option>
                                                @foreach ($this->units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </x-admin.components.input.select>
                                        </x-admin.components.input.group>
                                    </div>

                                    @if ($key > 0)
                                        <div class="col-span-1 flex items-end pb-3 text-gray-400 hover:text-red-500 " wire:loading.attr="disabled" wire:click="removeNutritionInput({{ $key }})">
                                            <x-icon style="solid" ref="trash" />
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="flex justify-end">
                                <x-admin.components.button type="button" theme="gray" wire:loading.attr="disabled" wire:click="addNutritionInput">
                                    Add Row
                                    <x-icon style="solid" ref="document-add" />
                                </x-admin.components.button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="dietry">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <header>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Dietary Restrictions
                                </h3>
                            </header>
                            <div class="grid grid-cols-10 gap-4">

                                @foreach ($dietaryRestrictions as $key => $dietaryRestriction)
                                    <div class="col-span-3">
                                        <x-admin.components.input.group for="dietaryRestriction" label="{{ $dietaryRestriction['name'] }}" :error="$errors->first('dietaryRestrictions.{{ $key }}.selected')">
                                            <x-admin.components.input.toggle id="value" name="dietaryRestriction" wire:model="dietaryRestrictions.{{ $key }}.selected" :error="$errors->first('dietaryRestrictions.{{ $key }}.selected')" :onValue="true" :offValue="false" />
                                        </x-admin.components.input.group>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div id="stock">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <div>
                                <x-admin.components.input.group for="name" label="Available Quantity" :error="$errors->first('product.available_quantity')">
                                    <x-admin.components.input.text id="value" name="name" placeholder="Value" wire:model.defer="product.available_quantity" :error="$errors->first('product.available_quantity')" />
                                </x-admin.components.input.group>
                            </div>
                            <div>
                                <x-admin.components.input.group for="name" label="Sale Unit" :error="$errors->first('product.unit_id')">
                                    <x-admin.components.input.select id="product.unit_id" wire:model.defer="product.unit_id">
                                        <option value="" disabled>Choose Unit
                                        </option>
                                        @foreach ($this->units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </x-admin.components.input.select>
                                </x-admin.components.input.group>
                            </div>
                            <div>
                                <x-admin.components.input.group for="price" label="Price" :error="$errors->first('product.price')">
                                    <x-admin.components.input.text id="value" name="name" placeholder="Value" wire:model.defer="product.price" :error="$errors->first('product.price')" />
                                </x-admin.components.input.group>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="images">
                    <x-admin.components.image-manager :existing="$images" :maxFileSize="3" :maxFiles="2" :multiple="false" model="imageUploadQueue" :filetypes="['image/*']" />
                    @error('images')
                        <div class="space-y-1">
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div id="collections">
                    <x-admin.components.category-manager :existing="$categories" />
                    @error('categories')
                        <div class="space-y-1">
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                    <div class="flex flex-row justify-end gap-x-2">
                        <x-admin.components.publish-dropdown wire:model.defer="product.is_published" />
                        <button class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">
                            {{ __($product->id ? 'catalog.product.form.update_btn' : 'catalog.product.form.create_btn') }}
                            @include('admin.layouts.livewire.button-loading')
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
