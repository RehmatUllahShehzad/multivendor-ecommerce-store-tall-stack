<x-slot name="pageTitle">
    {{ trans('global.message.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ trans('global.message.description') }}
</x-slot>
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
                @include('frontend.vendor.message._partials.message-listing-row', ['conversation' => $conversation, 'key' => $key])
            @empty
                <div class="product-reviews-wrapper">
                    <div class="product-review-cont">
                        <div class="product-text">
                            @include('frontend.vendor.message._partials.empty', ['message' => 'You didn\'t have any conversation'])
                        </div>
                    </div>
                </div>
            @endforelse

        </div>
        <div class="text-center product-pagination">
            {{ $conversations->onEachSide(1)->links('frontend.layouts.custom-pagination') }}
        </div>
    </div>
</div>
