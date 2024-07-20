<a href="{{ route('customer.message.show', $conversation->order_package_id) }}" class="message-cont {{ $key == 0 ? 'pt-0' : '' }}">
    <div class="buyer-name">
        @php
            $sender = $conversation->latestMessage->sender;
        @endphp
        <h4>{{  $sender->is(Auth::user()) ? $sender->name : $sender->vendor->vendor_name }}</h4>
        <h4>#<span>{{ $conversation->order->order_number }}</span></h4>
    </div>
    <div class="buyer-message {{ ! $conversation->latestMessage->isReadBy(auth()->user()) ? 'unread-message' : 'message' }}">
        <p> {{ $conversation->latestMessage->message }} </p>
        <div class="buyer-message-attachment">
            <h5>{{ $conversation->latestMessage->created_at->format('m-d-Y - h:i a') }}</h5>
        </div>
    </div>
</a>