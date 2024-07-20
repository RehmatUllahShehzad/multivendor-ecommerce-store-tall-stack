<?php

namespace App\Http\Livewire\Frontend\Customer\Message;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MessageIndexController extends UserAbstract
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
        return $this->view('frontend.customer.message.message-index-controller', function (View $view) {
            $view->with([
                'conversations' => $this->getConversations(),
            ]);
        });
    }

    public function getConversations(): Paginator
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        return $user
            ->conversations()
            ->with('order')
            ->withCount(['messages as unread_count' => fn ($q) => $q->read($user, true)])
            ->when(in_array($this->sortBy, [
                'unread', 'read',
            ]), fn ($q) => $q->orderBy('unread_count', $this->sortBy == 'read' ? 'ASC' : 'DESC'))
            ->paginate(10);
    }
}
