<?php

namespace App\Http\Livewire\Admin\Customer;

use App\Http\Livewire\Traits\Authenticated;
use App\Http\Livewire\Traits\Notifies;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;

class CustomerIndexController extends CustomerAbstract
{
    use Notifies,
        Authenticated;

    public string $search = '';

    public string $sortBy = 'default';

    public int $perPage;

    public function mount(): void
    {
        $this->perPage = 10;
    }

    public function render(): View
    {
        return $this->view('admin.customer.customer-index-controller', function (View $view) {
            $view->with('customers', $this->getCustomers());
        });
    }

    public function getCustomers(): Paginator
    {
        $query = User::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->sortBy == 'latest') {
            $query->latest('created_at');
        }

        if ($this->sortBy == 'oldest') {
            $query->oldest('created_at');
        }

        if ($this->sortBy == 'asc') {
            $query->orderBy('username', 'asc');
        }

        if ($this->sortBy == 'desc') {
            $query->orderBy('username', 'desc');
        }

        return $query
            ->latest('created_at')
            ->paginate($this->perPage);
    }
}
