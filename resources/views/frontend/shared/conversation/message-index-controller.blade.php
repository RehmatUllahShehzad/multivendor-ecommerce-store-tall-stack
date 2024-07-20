<x-slot name="pageTitle">
    {{ trans('global.message.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ trans('global.message.description') }}
</x-slot>
<div>
    <div class="vender-product-management-right">
        <div class="messaging-wrapper" id="messaging">
            <div class="product-manage-heading product-review-heading">
                <div class="header-select">
                    <h3>YOUR MESSAGES</h3>
                    <form method="get">
                        <div class="form-group">
                            <label for="exampleFormControlSelect9">Sort By:</label>
                            <select class="form-control" wire:model="sortBy" id="exampleFormControlSelect9">
                                <option value="">Sort by</option>
                                <option value="read">Read</option>
                                <option value="unread">Unread</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="message-wrap">

                @forelse ($conversations as $key => $conversation)
                    @include('frontend.shared.conversation._partials.message-listing-row', ['conversation' => $conversation, 'key' => $key])
                @empty
                    @include('frontend.shared.conversation._partials.empty', ['message' => 'You didn\'t have any conversation'])
                @endforelse

                {{ $conversations->onEachSide(1)->links('frontend.shared.conversation._partials.pagination') }}
                
            </div>
        </div>
    </div>
</div>
