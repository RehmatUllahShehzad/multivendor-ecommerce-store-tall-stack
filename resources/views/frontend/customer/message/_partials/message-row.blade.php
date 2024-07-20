<div class="message-cont">
    <div class="buyer-name">
        @php
            $sender = $message->sender;
        @endphp
        <h4>{{ $sender->is(Auth::user()) ? $sender->name : $sender->vendor->vendor_name }}</h4>
        <h4>#<span>{{ $order_number }}</span></h4>
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
                <label class="disabled" for="apply">
                    Image not added
                </label>
            @endif
            <h5>{{ $message->created_at->format('m-d-Y - h:i a') }}</h5>
        </div>
    </div>
</div>
