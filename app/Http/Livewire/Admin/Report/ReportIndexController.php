<?php

namespace App\Http\Livewire\Admin\Report;

use App\Services\Reports\ReportsService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReportIndexController extends Component
{
    public function render(ReportsService $reportsService): View
    {

        return view('admin.report.report-index-controller', [
            'topTenProducts' => $reportsService->getTopProducts(),
            'mostViewedProducts' => $reportsService->getMostViewedProducts(),
            'lastTenOrders' => $reportsService->getLastestOrders(),
            'topTenCustomers' => $reportsService->getTopCustomers(),
            'topTenVendors' => $reportsService->getTopVendors(),
        ])->layoutData([
            'title' => trans('reports.title'),
        ]);
    }
}
