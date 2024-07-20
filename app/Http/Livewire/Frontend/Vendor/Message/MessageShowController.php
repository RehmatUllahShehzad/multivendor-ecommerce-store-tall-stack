<?php

namespace App\Http\Livewire\Frontend\Vendor\Message;

use App\Http\Livewire\Frontend\Traits\WithReadMessage;
use App\Http\Livewire\Frontend\Traits\WithSendMessage;
use App\Http\Livewire\Frontend\VendorAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Models\OrderPackage;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MessageShowController extends VendorAbstract
{
    use WithFileUploads;
    use WithPagination;
    use WithBootstrapPagination;
    use ResetsPagination;
    use WithSendMessage;
    use WithReadMessage;

    public OrderPackage $orderPackage;

    public ?User $receiver = null;

    public string $textMessage = '';

    public function mount(): void
    {
        abort_if(! $this->orderPackage->user->is(Auth::user()), 404);

        $this->receiver = $this->orderPackage->customer;

        $this->receiverName = $this->receiver->username;

        abort_if(! $this->orderPackage->conversation, 404);

        $this->conversation = $this->orderPackage->conversation;

        $this->readMessages();
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.message.message-show-controller', function (View $view) {
            $view->with([
                'messages' => $this->getConversationMessages(),
            ]);
        });
    }
}
