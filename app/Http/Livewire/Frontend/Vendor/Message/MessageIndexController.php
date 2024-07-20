<?php

namespace App\Http\Livewire\Frontend\Vendor\Message;

use App\Http\Livewire\Frontend\VendorAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Models\Conversation;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MessageIndexController extends VendorAbstract
{
    use WithPagination,
        ResetsPagination,
        WithBootstrapPagination;

    public string $sortBy = '';

    /**
     * @var array<mixed>
     */
    protected $queryString = ['sortBy'];

    public function render(): View
    {
        return $this->view('frontend.vendor.message.message-index-controller', function (View $view) {
            $view->with('conversations', $this->getConversations());
        });
    }

    public function getConversations(): Paginator
    {
        return
            Conversation::query()
            ->join('order_packages', 'conversations.order_package_id', 'order_packages.id')
            ->with('order')
            ->withCount(['messages as unread_count' => fn ($q) => $q->read(Auth::user(), true)])
            ->when(in_array($this->sortBy, [
                'unread', 'read',
            ]), fn ($q) => $q->orderBy('unread_count', $this->sortBy == 'read' ? 'ASC' : 'DESC'))
            ->where('order_packages.vendor_id', Auth::id())
            ->paginate(10);
    }
}
