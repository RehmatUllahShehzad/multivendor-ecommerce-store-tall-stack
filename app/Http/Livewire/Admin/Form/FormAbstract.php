<?php

namespace App\Http\Livewire\Admin\Form;

use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Form;
use App\View\Components\Admin\Layouts\MasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class FormAbstract extends Component
{
    use Notifies,
        WithPagination,
        ResetsPagination;

    public Form $form;

    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(MasterLayout::class, [
                'title' => 'Form',
                'menuName' => 'form',
            ]);
    }
}
