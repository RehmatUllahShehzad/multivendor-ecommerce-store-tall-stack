<?php

namespace App\Http\Livewire\Frontend\Vendor;

use App\View\Components\Frontend\Layouts\GuestLayout;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        return view('frontend.vendor.dashboard')->layout(GuestLayout::class);
    }
}
