<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Http\Livewire\Traits\Authenticated;
use App\Http\Livewire\Traits\Notifies;
use App\Services\Dashboard\DashboardService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DashboardController extends Component
{
    use Notifies;
    use Authenticated;

    public function render(DashboardService $dashboardService): View
    {
        return view(
            'admin.dashboard.dashboard-controller',
            $dashboardService->getData()
        )->layoutData([
            'title' => trans('global.dashboard'),
        ]);
    }
}
