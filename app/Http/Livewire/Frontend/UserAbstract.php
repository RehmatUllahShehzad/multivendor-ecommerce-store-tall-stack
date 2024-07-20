<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Traits\Authenticated;
use App\View\Components\Frontend\Layouts\SubMasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserAbstract extends Component
{
    use Authenticated;

    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(SubMasterLayout::class, [
                'menuName' => 'customer',
            ]);
    }
}
