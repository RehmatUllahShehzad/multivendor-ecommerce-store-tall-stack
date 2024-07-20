<div class="space-y-4 order-summary-print">
    <header class="flex items-center justify-between">
        <strong class="text-gray-700 truncate">
            {{ $order->customer->name }}
        </strong>

        <a class="no-print flex-shrink-0 px-4 py-2 ml-4 text-xs font-bold text-gray-700 border rounded bg-gray-50 hover:bg-white" href="{{ route('admin.customer.show', $order->customer) }}">
            View customer
        </a>

    </header>

    <section class="bg-white rounded-lg shadow">
        <dl class="text-sm text-gray-600">
            <div class="grid items-center grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Status</dt>
                <dd class="text-right">
                    <span class="inline-block px-2 py-1 text-xs text-white rounded" style="background: #6a67ce;">
                        Payment Received
                    </span>
                </dd>
            </div>

            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Reference</dt>
                <dd class="text-right">
                    {{ $order->order_number }}
                </dd>
            </div>
            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b no-print">
                <dt class="font-medium text-gray-500">Print Summary</dt>
                <dd class="text-right">
                    <button class="inline-block px-2 py-1 text-xs text-white rounded" style="background: #6a67ce;" onclick="print()">
                        Print
                    </button>
                </dd>
            </div>
            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Service Fee</dt>
                <dd class="text-right">
                    {{ $package->service_fee }}
                </dd>
            </div>
            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Total Amount</dt>
                <dd class="text-right">
                    {{ number_format($order->total_amount, 2) }}
                </dd>
            </div>

            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Customer Reference</dt>
                <dd class="text-right"></dd>
            </div>

            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Channel</dt>
                <dd class="text-right">Webstore</dd>
            </div>

            <div class="grid grid-cols-2 gap-2 px-4 py-3 border-b">
                <dt class="font-medium text-gray-500">Date Placed</dt>
                <dd class="text-right">
                    {{ $order->created_at->format('m/d/Y') }}
                </dd>
            </div>
        </dl>
    </section>

    <section class="p-4 bg-white rounded-lg shadow break-before-page">
        <header class="flex items-center justify-between">
            <strong class="text-gray-700">
                Shipping Address
            </strong>
        </header>

        <address class="mt-4 text-sm not-italic text-gray-600">
            {{ $order->shippingAddress->address_1 ?? '' }} <br>
            {{ $order->shippingAddress->address_2 ?? '' }} <br>

            {{ $order->shippingAddress->city ?? '' }} <br>

            {{ $order->shippingAddress->state->name ?? '' }} <br>

            {{ $order->shippingAddress->zip ?? '' }} <br>

            United States
        </address>
    </section>

    <section class="p-4 bg-white rounded-lg shadow">
        <header class="flex items-center justify-between">
            <strong class="text-gray-700">
                Billing Address
            </strong>
        </header>

        <address class="mt-4 text-sm not-italic text-gray-600">
            {{ $order->cart->billingAddress->address_1 }} <br>
            {{ $order->cart->billingAddress->address_2 }} <br>

            {{ $order->cart->billingAddress->city }} <br>

            {{ $order->cart->billingAddress->state->name }} <br>

            {{ $order->cart->billingAddress->zip }} <br>

            United States
        </address>
    </section>
</div>
