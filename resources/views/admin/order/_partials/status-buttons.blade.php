<div class="flex items-center space-x-2 text-xs text-gray-700">
    <button class="inline-flex items-center px-4 py-2 font-bold transition border border-transparent border-gray-200 rounded hover:bg-white bg-gray-50 hover:border-gray-200" type="button" wire:click.prevent="$set('showRefund', true)">
        <div>
            <svg class="w-4 mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.4453 14.8321C8.75216 15.0366 9.1467 15.0557 9.47186 14.8817C9.79701 14.7077 10 14.3688 10 14L10 11.2019L15.4453 14.8321C15.7522 15.0366 16.1467 15.0557 16.4719 14.8817C16.797 14.7077 17 14.3688 17 14V6C17 5.63121 16.797 5.29235 16.4719 5.11833C16.1467 4.94431 15.7522 4.96338 15.4453 5.16795L10 8.79815V6C10 5.63121 9.79702 5.29235 9.47186 5.11833C9.1467 4.94431 8.75216 4.96338 8.4453 5.16795L2.4453 9.16795C2.1671 9.35342 2 9.66565 2 10C2 10.3344 2.1671 10.6466 2.4453 10.8321L8.4453 14.8321Z" fill="#374151"></path>
            </svg>

        </div>

        Refund

    </button>

    <button class="inline-flex items-center px-4 py-2 font-bold transition border border-transparent border-gray-200 rounded hover:bg-white bg-gray-50 hover:border-gray-200" type="button" wire:click.prevent="$set('showUpdateStatus', true)">
        <div>
            <svg class="w-4 mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">

                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6C3 4.34315 4.34315 3 6 3H16C16.3788 3 16.725 3.214 16.8944 3.55279C17.0638 3.89157 17.0273 4.29698 16.8 4.6L14.25 8L16.8 11.4C17.0273 11.703 17.0638 12.1084 16.8944 12.4472C16.725 12.786 16.3788 13 16 13H6C5.44772 13 5 13.4477 5 14V17C5 17.5523 4.55228 18 4 18C3.44772 18 3 17.5523 3 17V6Z" fill="currentColor"></path>
            </svg>

        </div>

        Update Status
    </button>

    <div class="relative flex justify-end flex-1" x-data="{ showMenu: false }">
        <div>

            <button class="inline-flex items-center px-4 py-2 font-bold transition border rounded hover:bg-white bg-gray-50" type="button" x-on:click="showMenu = !showMenu">
                More Actions

                <div>
                    <svg class="w-4 ml-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">

                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z" fill="currentColor"></path>
                    </svg>

                </div>
            </button>

            <div class="absolute right-0 z-50 w-screen max-w-[200px] mt-2 text-sm bg-white border rounded-lg shadow-lg top-full overflow-hidden" role="menu" style="display: none;" x-on:click.away="showMenu = false" x-show="showMenu" x-transition="">

                <div wire:id="oyy4dDyPast9oQxB0dYj">
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="#" role="menuitem" tabindex="-1" wire:click="$set('showForm', true)">Tracking Number</a>

                    <div class="fixed inset-x-0 top-0 px-4 pt-6 z-75 sm:px-0 sm:flex sm:items-top sm:justify-center" id="40298f75b796712118370f195adb44bc" style="display: none;" x-data="{
                        show: window.Livewire.find('oyy4dDyPast9oQxB0dYj').entangle('showForm'),
                        focusables() {
                            // All focusable element types...
                            let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
                    
                            return [...$el.querySelectorAll(selector)]
                                // All non-disabled elements...
                                .filter(el => !el.hasAttribute('disabled'))
                        },
                        firstFocusable() { return this.focusables()[0] },
                        lastFocusable() { return this.focusables().slice(-1)[0] },
                        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
                        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
                        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
                        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
                        autofocus() { let focusable = $el.querySelector('[autofocus]'); if (focusable) focusable.focus() },
                    }" x-init="$watch('show', value => value & amp; & amp; setTimeout(autofocus, 50))" x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()" x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show">
                        <div class="fixed inset-0 transition-all" style="display: none;" x-show="show" x-on:click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <div class="bg-white rounded-lg shadow-xl transition-all sm:w-full z-75 sm:max-w-2xl" style="display: none;" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <form wire:submit.prevent="save">
                                <div class="px-6 py-4">
                                    <div class="text-lg">
                                        Tracking Number
                                    </div>

                                    <div class="mt-4">
                                        <input class="form-input block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed" type="text" wire:model="meta.tracking_number" maxlength="255">
                                    </div>
                                </div>

                                <div class="px-6 py-4 text-right bg-gray-100 rounded-b">
                                    <button class="py-2 px-4 text-sm bg-white text-gray-600 border-gray-300 hover:bg-gray-100 focus:ring-gray-400 block disabled:cursor-not-allowed disabled:opacity-50 border border-transparent rounded-lg shadow-sm inline-flex justify-center font-medium focus:outline-none focus:ring-offset-2 focus:ring-2" type="button" wire:click.prevent="$set('showForm', false)">
                                        Cancel
                                    </button>
                                    <button class="py-2 px-4 text-sm bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 block disabled:cursor-not-allowed disabled:opacity-50 border border-transparent rounded-lg shadow-sm inline-flex justify-center font-medium focus:outline-none focus:ring-offset-2 focus:ring-2" type="submit">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
