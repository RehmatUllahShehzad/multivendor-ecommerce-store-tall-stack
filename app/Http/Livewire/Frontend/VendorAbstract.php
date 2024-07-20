<?php

namespace App\Http\Livewire\Frontend;

use App\View\Components\Frontend\Layouts\SubMasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class VendorAbstract extends Component
{
    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(SubMasterLayout::class, [
                'menuName' => 'vendor',
                'unReadMessageCount' => 0, // TODO: fix when work on vendor module
            ]);
    }
}
