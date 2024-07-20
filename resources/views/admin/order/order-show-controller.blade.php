<section class="px-12 mx-auto max-w-7xl">
    <header class="flex items-center">
        <h1 class="text-lg font-bold text-gray-900 md:text-2xl">
            <span class="text-gray-500">Order</span> #{{ $order->order_number }}
        </h1>
    </header>

    <div class="grid grid-cols-1 gap-8 mt-8 lg:items-start lg:grid-cols-3">
        <div class="lg:col-span-2">
            {{-- @include('admin.order._partials.status-buttons') --}}
            <div class="mt-4"></div>
            @foreach ($order->packages as $package)
                <div class="p-6 mt-4 bg-white rounded-lg shadow my-1 {{ !$loop->last ? 'break-after-page' : '' }} break-before-page">
                    <h4 class="font-bold border-b">{{ $package->vendor->vendor_name }}</h4>
                    <div class="flow-root">
                        <ul class="divide-y divide-gray-100">
                            @foreach ($package->items as $packageItem)
                                <li class="py-3 {{ $loop->iteration % 11 == 0 ? 'break-after-page' : '' }}" x-data="{ showDetails: false }">
                                    <div class="flex items-center">
                                        <div class="flex gap-2">
                                            {{-- <input class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer hover:bg-gray-50 focus:ring-indigo-500" type="checkbox" value="37" wire:model="selectedLines"> --}}
                                            <div class="flex-shrink-0 p-1 overflow-hidden border border-gray-100 rounded">
                                                <img class="object-contain w-8 h-8" src="{{ $packageItem->product->getThumbnailUrl() }}">
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <div class="gap-8 xl:justify-between xl:items-start xl:flex">
                                                <div class="relative flex items-center justify-between gap-4 pl-8 xl:justify-end xl:pl-0 xl:order-last" x-data="{ showMenu: false }">
                                                    <p class="text-sm font-medium text-gray-700">
                                                        {{ $packageItem->quantity }} x ${{ $packageItem->price }}
                                                        <span class="ml-1">
                                                          =  ${{ $packageItem->total() }}
                                                        </span>
                                                    </p>

                                                </div>

                                                <button class="flex mt-2 group xl:mt-0" type="button" x-on:click="showDetails = !showDetails">
                                                    <div class="transition-transform -rotate-90" :class="{ '-rotate-90 ': !showDetails }">
                                                        <div>
                                                            <svg class="w-6 mx-1 text-gray-400 -mt-7 group-hover:text-gray-500 xl:mt-0" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">

                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z" fill="currentColor"></path>
                                                            </svg>

                                                        </div>
                                                    </div>
                                                    <div class="max-w-sm space-y-2 text-left">
                                                        <div class="relative flex justify-left" x-data="{
                                                            showToolTip: false
                                                        }" @mouseenter="showToolTip = true" @mouseleave="showToolTip = false">
                                                            <div class="absolute z-50 p-2 -mt-10 text-xs text-white bg-gray-900 rounded-md whitespace-nowrap" style="display: none;" x-show="showToolTip">
                                                                {{ $packageItem->product->title }}
                                                            </div>
                                                            <p class="text-sm font-bold leading-tight text-gray-800 truncate">
                                                                {{ $packageItem->product->title }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="no-print pl-[calc(8rem_-_10px)] text-gray-700" style="display: none;" x-show="showDetails">
                                        <div class="pt-4 mt-4 space-y-4 border-t border-gray-200">
                                            <article class="text-sm">
                                                <p>
                                                    <strong>Notes:</strong>

                                                </p>
                                            </article>

                                            <div class="overflow-hidden overflow-x-auto border border-gray-200 rounded">
                                                <table class="min-w-full text-xs divide-y divide-gray-200">
                                                    <tbody class="divide-y divide-gray-200">
                                                        <tr class="divide-x divide-gray-200">
                                                            <td class="p-2 font-medium text-gray-900 whitespace-nowrap">
                                                                Unit Price
                                                            </td>

                                                            <td class="p-2 text-gray-700 whitespace-nowrap">
                                                                ${{ $packageItem->price }}
                                                            </td>
                                                        </tr>

                                                        <tr class="divide-x divide-gray-200">
                                                            <td class="p-2 font-medium text-gray-900 whitespace-nowrap">
                                                                Quantity
                                                            </td>

                                                            <td class="p-2 text-gray-700 whitespace-nowrap">
                                                                {{ $packageItem->quantity }}
                                                            </td>
                                                        </tr>

                                                        <tr class="divide-x divide-gray-200">
                                                            <td class="p-2 font-medium text-gray-900 whitespace-nowrap">
                                                                Sub Total
                                                            </td>

                                                            <td class="p-2 text-gray-700 whitespace-nowrap">
                                                                ${{ $packageItem->total() }}
                                                            </td>
                                                        </tr>

                                                        <tr class="divide-x divide-gray-200">
                                                            <td class="p-2 font-medium text-gray-900 whitespace-nowrap">
                                                                Discount Total
                                                            </td>

                                                            <td class="p-2 text-gray-700 whitespace-nowrap">
                                                                $0.00
                                                            </td>
                                                        </tr>

                                                        <tr class="divide-x divide-gray-200">
                                                            <td class="p-2 font-medium text-gray-900 whitespace-nowrap">
                                                                Total
                                                            </td>

                                                            <td class="p-2 text-gray-700 whitespace-nowrap">
                                                                ${{ $packageItem->total() }}
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-8">
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <ul class="space-y-2 text-sm text-gray-900">
                            </ul>

                            <div class="grid grid-cols-3 gap-4 pt-4 mt-4 border-t">
                                <div class="col-span-2">
                                    <article>
                                        <strong>Notes:</strong>

                                        <p class="text-sm mt-1 text-gray-500">
                                            No notes on this order
                                        </p>
                                    </article>
                                </div>

                                <div>
                                    <dl class="space-y-1 text-sm text-right text-gray-700">
                                        <div class="flex justify-between">
                                            <dt>Sub Total</dt>
                                            <dd>${{ $package->sub_total }}</dd>
                                        </div>
                                        
                                        <div class="flex justify-between">
                                            <dt>Shipping Total</dt>
                                            <dd>${{ $package->shipping_fee }}</dd>
                                        </div>

                                        <div class="flex justify-between font-bold text-gray-900">
                                            <dt>Total</dt>
                                            <dd>${{ number_format($package->total(), 2) }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                <header class="sr-only">
                    Transactions
                </header>

                <ul class="space-y-4 no-print">
                    @foreach ($order->transactions as $transaction)
                        <li class="text-sm bg-white borderborder-green-300 rounded-lg shadow-sm ">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center gap-6">
                                    <div>
                                        <strong class="text-xs text-gray-500">
                                            {{ $transaction->status }}
                                        </strong>
                                    </div>

                                    <div>
                                        <svg class="w-10" viewBox="0 0 50 50">
                                            <use xlink:href="#{{ $transaction->card_type }}"></use>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        <span class="inline-block -translate-y-px">
                                            ∗∗∗∗ ∗∗∗∗ ∗∗∗∗
                                        </span>

                                        <span class="font-medium">
                                            {{ $transaction->last_four }}
                                        </span>
                                    </p>
                                </div>

                                <strong class="text-sm  text-gray-900 ">
                                    ${{ number_format($transaction->amount, 2) }}
                                </strong>

                            </div>
                            <div class="bottom-0 left-0 block w-full text-center rounded-b-lg border-t text-xs py-1 bg-green-50 border-green-300 text-green-600       ">
                                {{ $transaction->type }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- @include('admin.order._partials.timeline') --}}
        </div>

        @include('admin.order._partials.sidebar')
    </div>
</section>
