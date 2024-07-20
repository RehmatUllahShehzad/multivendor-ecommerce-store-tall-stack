<x-slot name="pageTitle">
    {{ trans('global.message.detail.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ trans('global.message.detail.description') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="personal-messaging-wrap " id="PersonalMessaging">
        <div class="product-manage-heading product-review-heading">
            <div class="header-select">
                <h3>YOUR MESSAGES</h3>
                <span>Status: {{ $orderPackage->order->status->name }}</span>
            </div>
        </div>
        <div class="personal-messages">
            @if (!$orderPackage->isCompleted())
                <div class="personal-reply">
                    <form wire:submit.prevent="sendMessage">
                        <div class="form-group">
                            <textarea class="form-control" id="exampleFormControlTextarea1" aria-labelledby="exampleFormControlTextarea1" wire:model.defer="textMessage" rows="3" placeholder="Message"></textarea>
                            @error('textMessage')
                                <div class="error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="personal-file mt-5">
                            <div class="form-group">
                                @if ($file)
                                    <a target="_blank" href="{{ $file->temporaryUrl() }}">{{ $file->getClientOriginalName() }}</a>
                                    <button type="button" class="btn btn-link text-danger file-btn" wire:click="removeAttachment">X</button>
                                @else
                                    <input class="form-control-file" id="{{ rand() }}" type="file" aria-labelledby="exampleFormControlFile1" wire:model.defer="file">
                                @endif
                                @error('file')
                                    <div class="error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="personal-btn">
                                <p>{{ '@' . $receiverName ?? '' }}</p>
                                <button class="checkout-cart-button" type="submit" wire:click>Send
                                    <x-button-loading wire:loading />
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
            @if ($conversation)
                @foreach ($messages as $message)
                    @include('frontend.vendor.message._partials.message-row', ['message' => $message, 'order_number' => $orderPackage->order->order_number])
                @endforeach
                <div class="reviews-pages">
                    <p></p>

                    {{ $messages->links() }}

                </div>
            @else
                @include('frontend.vendor.message._partials.empty', ['message' => 'Conversation not started yet!'])
            @endif

        </div>
    </div>
</div>
