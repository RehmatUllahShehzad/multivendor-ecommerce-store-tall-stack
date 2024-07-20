<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\Product;
use App\Models\User;
use App\Services\Reports\ReportsService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    private ReportsService $reportServices;

    public function __construct()
    {
        $this->reportServices = new ReportsService();
    }

    public function getData(): array
    {
        return [
            'totalUsers' => $this->getTotalUsersCount(),
            'totalSales' => $this->getTotalSaleOfAllVendors(),
            'totalPayables' => $this->getTotalPayableOfAllVendors(),
            'totalProducts' => $this->getTotalProductsCount(),
            'totalOrders' => $this->getTotalOrdersCount(),
            'recentOrders' => $this->reportServices->getLastestOrders(6),
            'topSellingProducts' => $this->reportServices->getTopProducts(2),
        ];
    }

    public function getTotalSaleOfAllVendors(): float
    {
        return OrderPackage::query()
            ->completed()
            ->select(
                DB::raw('SUM(sub_total + shipping_fee) as total')
            )
            ->get()
            ->sum('total');
    }

    public function getTotalPayableOfAllVendors()
    {
        return User::has('vendor')->sum('balance');
    }

    public function getTotalUsersCount(): int
    {
        return User::all()->count();
    }

    public function getTotalProductsCount(): int
    {
        return Product::count();
    }

    public function getTotalOrdersCount(): int
    {
        return Order::count();
    }

    /**
     * Return the computed sales performance.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSalesPerformance(array $range): Collection
    {
        $start = now()->parse($range['from']);
        $end = now()->parse($range['to']);

        $periodQuery = Order::getQuery()
            ->select(
                DB::RAW('ROUND(SUM(total_amount), 2) as total_amount'),
                (db_date('created_at', '%Y-%m', 'format_date'))
            )
            ->groupBy('format_date');

        $thisPeriod = $periodQuery
            ->clone()
            ->whereBetween('created_at', [
                $start,
                $end,
            ])
            ->get();

        $previousPeriod = $periodQuery
            ->clone()
            ->whereBetween('created_at', [
                $start->clone()->subYear(),
                $end->clone()->subYear(),
            ])
            ->get();

        $period = CarbonPeriod::create($start, '1 month', $end);

        $thisPeriodMonths = collect();
        $previousPeriodMonths = collect();
        $months = collect();

        foreach ($period as $datetime) {
            $months->push($datetime->toDateTimeString());
            // Do we have some totals for this month?
            if ($totals = $thisPeriod->first(fn ($p) => $p->format_date == $datetime->format('Y-m'))) {
                $thisPeriodMonths->push($totals->total_amount);
            } else {
                $thisPeriodMonths->push(0);
            }

            if ($prevTotals = $previousPeriod->first(fn ($p) => $p->format_date == $datetime->format('Y-m'))) {
                $previousPeriodMonths->push($prevTotals->total_amount);
            } else {
                $previousPeriodMonths->push(0);
            }
        }

        return collect([
            'chart' => [
                'type' => 'area',
                'toolbar' => [
                    'show' => false,
                ],
                'height' => '100%',
                'zoom' => [
                    'enabled' => false,
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shadeIntensity' => 1,
                    'opacityFrom' => 0.45,
                    'opacityTo' => 0.05,
                    'stops' => [50, 100, 100, 100],
                ],
            ],
            'series' => [
                [
                    'name' => 'This Period',
                    'data' => $thisPeriodMonths->toArray(),
                ],
                [
                    'name' => 'Previous Period',
                    'data' => $previousPeriodMonths->toArray(),
                ],
            ],
            'xaxis' => [
                'type' => 'datetime',
                'categories' => $months->toArray(),
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Turnover USD',
                ],
            ],
            'tooltip' => [
                'x' => [
                    'format' => 'dd MMM yyyy',
                ],
            ],
        ]);
    }
}
