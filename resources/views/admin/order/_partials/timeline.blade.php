<div class="mt-4">
    <header class="my-6 font-medium">
        Timeline
    </header>

    <div class="flex items-center mt-4">
        <div class="flex-shrink-0">
            <div wire:id="ayohsCqvPBowvJJXOvW8">
                <img class="inline-block w-10 h-10 rounded-full" src="https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp">
            </div>
        </div>

        <form class="relative w-full ml-4" wire:submit.prevent="addComment">
            <textarea class="w-full pl-4 pr-32 pt-5 border border-gray-200 rounded-lg h-[58px] sm:text-sm form-text" type="text" placeholder="Add a comment" wire:model.defer="comment" required="" multiline="">            </textarea>

            <button class="absolute h-[42px] text-xs font-bold leading-[42px] text-gray-700 bg-gray-100 border border-transparent rounded-md hover:border-gray-100 hover:bg-gray-50 w-28 top-2 right-2" type="submit">
                <div wire:loading.remove="" wire:target="addComment">
                    Add Comment
                </div>
                <div wire:loading="" wire:target="addComment">
                    <div>
                        <svg class="inline-block rotate-180 animate-spin" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="currentColor"></path>
                        </svg>

                    </div>
                </div>

            </button>
        </form>
    </div>

    <div class="relative pt-8">
        <span class="absolute inset-y-0 left-5 w-[2px] bg-gray-200"></span>

        <div class="flow-root">
            <ul class="-my-8 divide-y-2 divide-gray-200" role="list">
                <li class="relative py-8 ml-5">
                    <p class="ml-8 font-bold text-gray-900">
                        August 23rd, 2022
                    </p>

                    <ul class="mt-4 space-y-6">
                        <li class="relative pl-8">

                            <div class="absolute top-[2px] -left-[calc(0.5rem_-_1px)]">
                                <img class="w-5 h-5 rounded-full" src="https://www.gravatar.com/avatar/3f009d72559f51e7e454b16e5d0687a1?s=100&amp;d=mp">
                            </div>

                            <div class="flex justify-between">
                                <div>
                                    <div class="text-xs font-medium text-gray-500">
                                        Eliana Moss
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-700">
                                    </p>
                                    <div class="flex items-center text-sm font-medium text-gray-700">
                                        Status updated
                                        <div class="flex items-center ml-2">
                                            <strong><span class="inline-block px-2 py-1 text-xs text-white rounded" style="background: #848a8c;">
                                                    Awaiting Payment
                                                </span></strong>
                                            <div>
                                                <svg class="w-4 mx-1" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">

                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z" fill="currentColor"></path>
                                                </svg>

                                            </div>
                                            <strong><span class="inline-block px-2 py-1 text-xs text-white rounded" style="background: #6a67ce;">
                                                    Payment Received
                                                </span></strong>
                                        </div>
                                    </div>
                                    <p></p>
                                </div>

                                <time class="flex-shrink-0 ml-4 text-xs mt-0.5 text-gray-500 font-medium">
                                    06:02am
                                </time>
                            </div>
                        </li>
                        <li class="relative pl-8">

                            <div class="absolute top-[2px] -left-[calc(0.5rem_-_1px)]">
                                <img class="w-5 h-5 rounded-full" src="https://www.gravatar.com/avatar/3f009d72559f51e7e454b16e5d0687a1?s=100&amp;d=mp">
                            </div>

                            <div class="flex justify-between">
                                <div>
                                    <div class="text-xs font-medium text-gray-500">
                                        Eliana Moss
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-700">
                                        Payment of $233.75 on card ending 1111
                                    </p>
                                </div>

                                <time class="flex-shrink-0 ml-4 text-xs mt-0.5 text-gray-500 font-medium">
                                    06:02am
                                </time>
                            </div>
                        </li>
                        <li class="relative pl-8">

                            <div class="absolute top-[2px] -left-[calc(0.5rem_-_1px)]">
                                <img class="w-5 h-5 rounded-full" src="https://www.gravatar.com/avatar/3f009d72559f51e7e454b16e5d0687a1?s=100&amp;d=mp">
                            </div>

                            <div class="flex justify-between">
                                <div>
                                    <div class="text-xs font-medium text-gray-500">
                                        Eliana Moss
                                    </div>
                                    <p class="mt-2 text-sm font-medium text-gray-700">
                                        Order Created
                                    </p>
                                </div>

                                <time class="flex-shrink-0 ml-4 text-xs mt-0.5 text-gray-500 font-medium">
                                    06:02am
                                </time>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>