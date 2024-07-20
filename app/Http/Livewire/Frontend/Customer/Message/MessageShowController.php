<?php

namespace App\Http\Livewire\Frontend\Customer\Message;

use App\Http\Livewire\Frontend\Traits\WithReadMessage;
use App\Http\Livewire\Frontend\Traits\WithSendMessage;
use App\Http\Livewire\Frontend\UserAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Models\OrderPackage;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MessageShowController extends UserAbstract
{
    use WithFileUploads;
    use WithPagination;
    use WithBootstrapPagination;
    use ResetsPagination;
    use WithSendMessage;
    use WithReadMessage;

    public OrderPackage $orderPackage;

    public ?Vendor $receiver = null;

    public string $textMessage = '';

    public function mount(): void
    {
        abort_if(! $this->orderPackage->customer->is(Auth::user()), 404);

        $this->receiver = $this->orderPackage->vendor;

        $this->receiverName = $this->receiver->vendor_name;

        $this->conversation = $this->orderPackage->conversation;

        if (! $this->orderPackage->conversation) {
            return;
        }

        if ($this->orderPackage->isCompleted()) {
            return;
        }

        $this->readMessages();
    }

    public function render(): View
    {
        return $this->view('frontend.customer.message.message-show-controller', function (View $view) {
            $view->with([
                'messages' => $this->getConversationMessages(),
            ]);
        });
    }
}
