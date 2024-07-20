<?php

namespace App\View\Components;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MessageReadNotification extends Component
{
    public int $unReadMessageCount = 0;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->unReadMessageCount = $this->conversationCount();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.message-read-notification');
    }

    public function conversationCount(): int
    {
        return Message::query()->read(Auth::user(), false)->count();

    }
}
