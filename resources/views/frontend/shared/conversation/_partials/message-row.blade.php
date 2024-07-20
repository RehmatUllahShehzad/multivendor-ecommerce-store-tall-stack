<div class="message-cont">
    <div class="buyer-name">
        <h4>{{ $message->sender->name }}</h4>
        <h4>#{{ $order_number }}</h4>
    </div>
    <div class="buyer-message">
        <p> {{ $message->message }} </p>
        <div class="buyer-message-attachment">
            @if ($message->hasMedia('App\Models\Message'))
                <a href="{{ $message->getFirstMediaUrl('App\Models\Message') }}">
                    <label for="apply">
                        Attachment <i class="fas fa-paperclip"></i>
                    </label>
                </a>
            @else
                <label for="apply" class="disabled">
                    Image not added
                </label>
            @endif
            <h5>{{ $message->created_at->format('m-d-Y - h:i a') }}</h5>
        </div>
    </div>
</div>