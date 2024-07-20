<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        return view('frontend.customer.dashboard')->layout(MasterLayout::class, [
            'title' => trans('global.customer.dashboard.title'),
            'description' => trans('global.customer.dashboard.title'),
            'keywords' => '',
        ]);
    }
}
