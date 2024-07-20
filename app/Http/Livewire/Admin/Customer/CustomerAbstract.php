<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\User;
use App\View\Components\Admin\Layouts\MasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAbstract extends Component
{
    use Notifies,
        WithPagination,
        ResetsPagination;

    public User $customer;

    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(MasterLayout::class, [
                'title' => 'Customers',
                'menuName' => 'customer',
            ]);
    }
}
