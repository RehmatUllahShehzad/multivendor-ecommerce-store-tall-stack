<?php

namespace App\Http\Livewire\Frontend\Traits;

use Illuminate\Support\Facades\Auth;

trait WithReadMessage
{
    public function readMessages()
    {
        $this->conversation->messages()->where('receiver_id', Auth::id())->update(['is_read' => 1]);
    }
}
