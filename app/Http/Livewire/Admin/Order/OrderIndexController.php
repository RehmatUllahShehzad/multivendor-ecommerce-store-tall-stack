<?php

namespace App\Http\Livewire\Admin\Order;

use App\Models\Order;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;

class OrderIndexController extends OrderAbstract
{
    public string $search = '';

    public int $perPage = 10;

    /**
     * The date range for the dashboard reports.
     *
     * @var array
     */
    public array $range = [
        'from' => null,
        'to' => null,
    ];

    /**
     * {@inheritDoc}
     */
    protected $queryString = ['range'];

    public function rules()
    {
        return [
            'range.from' => 'date',
            'range.to' => 'date,after:range.from',
        ];
    }

    public function mount(): void
    {
        $this->search = '';
        $this->range['from'] = $this->range['from'] ?? now()->startOfWeek()->format('Y-m-d');
        $this->range['to'] = $this->range['to'] ?? now()->endOfWeek()->format('Y-m-d');
    }

    public function render(): View
    {
        return $this->view('.admin.order.order-index-controller', function (View $view) {
            $view->with('orders', $this->getOrders());
        });
    }

    public function getOrders(): Paginator
    {
        if ($this->range['from'] == '' && $this->range['to'] == '') {
            return Order::query()
                ->when($this->search, fn ($query) => $query->searchOrders($this->search))
                ->latest('created_at')
                ->paginate($this->perPage);
        }

        return Order::query()
            ->when($this->search, fn ($query) => $query->searchOrders($this->search))
            ->whereBetween('created_at', [
                now()->parse($this->range['from'])->startOfDay(),
                now()->parse($this->range['to'])->endOfDay(),
            ])
            ->latest('created_at')
            ->paginate($this->perPage);
    }
}
