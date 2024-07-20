<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Services\Dashboard\DashboardService;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class SalesPerformance extends Component
{
    /**
     * A unique key for the chart
     *
     * @var string
     */
    public $key;

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

    public function mount(): void
    {
        $this->key = 'apex-'.md5(Str::random(100));

        $this->range['from'] = $this->range['from'] ?? now()->startOfMonth()->format('Y-m-d');

        $this->range['to'] = $this->range['to'] ?? now()->endOfMonth()->format('Y-m-d');
    }

    public function rules(): array
    {
        return [
            'range.from' => 'date',
            'range.to' => 'date,after:range.from',
        ];
    }

    public function render(): View
    {
        return view('admin.dashboard.sales-performance', [
            'options' => $this->getChartOptions(),
        ]);
    }

    public function updatedRange()
    {
        $this->emitSelf('chart-updated', $this->getChartOptions());
    }

    public function getChartOptions()
    {
        return app(DashboardService::class)->getSalesPerformance($this->range);
    }
}
