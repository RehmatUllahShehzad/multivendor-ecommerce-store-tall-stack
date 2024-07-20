<x-slot name="pageTitle">
    {{ trans('global.message.degtail.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ trans('global.message.degtail.description') }}
</x-slot>
<div>
    <div class="vender-product-management-right">
        <div class="personal-messaging-wrap " id="PersonalMessaging">
            <div class="product-manage-heading product-review-heading">
                <div class="header-select">
                    <h3>YOUR MESSAGES</h3>
                    <span>Status: {{ $conversation->order->status->name }}</span>
                </div>
            </div>
            <div class="personal-messages">
                <div class="personal-reply">
                    <form wire:submit.prevent="sendMessage">
                        <div class="form-group">
                            <textarea class="form-control" aria-labelledby="exampleFormControlTextarea1" wire:model.defer="textMessage" id="exampleFormControlTextarea1" rows="3" placeholder="Message"></textarea>
                            @error('textMessage')
                                <div class="error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="personal-file mt-5">
                            <div class="form-group">
                                @if ( $file )
                                    <a href="{{ $file->temporaryUrl() }}">{{  $file->getClientOriginalName()  }}</a>
                                @else
                                    <input type="file" class="form-control-file" wire:model.defer="file" aria-labelledby="exampleFormControlFile1" id="{{ rand() }}">
                                @endif
                                @error('file')
                                    <div class="error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="personal-btn">
                                <p>{{ '@'.$vendorName ?? '' }}</p>
                                <button class="checkout-cart-button" wire:click type="submit">Send
                                    <x-button-loading wire:loading/>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @if (! empty($conversation))
                    @foreach ($messages as $message)
                        @include('frontend.shared.conversation._partials.message-row', ['message' => $message, 'order_number' => $conversation->order->order_number])
                    @endforeach
                @else
                    @include('frontend.shared.conversation._partials.empty', ['message' => 'Conversation not started yet!'])
                @endif
                
                <div class="reviews-pages">
                    <p></p>

                    {{ $messages->links() }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
