<?php

namespace App\Http\Livewire\Admin\Cms;

use App\Http\Livewire\Traits\Authenticated;
use App\Http\Livewire\Traits\Notifies;
use App\View\Components\Admin\Layouts\SubMasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

abstract class CmsAbstract extends Component
{
    use Authenticated, Notifies, WithFileUploads;

    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(SubMasterLayout::class, [
                'menuName' => 'cms',
            ]);
    }
}
