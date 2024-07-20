<a href="{{ route('customer.message.show', $conversation->order_package_id) }}" class="message-cont {{ $key == 0 ? 'pt-0' : '' }}">
    <div class="buyer-name">
        <h4>{{ $conversation->latestMessage->sender->name }}</h4>
        <h4>#{{ $conversation->order->order_number }}</h4>
    </div>
    <div class="buyer-message {{ ! $conversation->latestMessage->is_read ? 'unread-message' : 'message' }}">
        <p> {{ $conversation->latestMessage->message }} </p>
        <div class="buyer-message-attachment">
            <h5>{{ $conversation->latestMessage->created_at->format('m-d-Y - h:i a') }}</h5>
        </div>
    </div>
</a>