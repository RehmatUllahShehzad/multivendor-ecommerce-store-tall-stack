<?php

namespace App\Services\Reports;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ReportsService
{
    public function getTopProducts(int $limit = 10): Collection
    {
        return Product::whereHas('orderPackagesItems')
            ->with('media')
            ->withCount('orderPackagesItems as total_sale')
            ->withAggregate('orderPackagesItems as total_price', 'sum(quantity * price)')
            ->orderByDesc('total_price')
            ->limit($limit)
            ->get();
    }

    public function getMostViewedProducts(int $limit = 5): Collection
    {
        return Product::whereHas('productViews')
            ->withCount('productViews')
            ->orderByDesc('product_views_count')
            ->limit($limit)
            ->get();
    }

    public function getLastestOrders(int $limit = 10): Collection
    {
        return Order::wherehas('customer')
            ->with('customer')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getTopCustomers(int $limit = 10): Collection
    {
        return User::whereHas('orders')
            ->withSum('orders as revenue', 'total_amount')
            ->orderByDesc('revenue')
            ->limit($limit)
            ->get();
    }

    public function getTopVendors(int $limit = 10): Collection
    {
        return User::has('vendor')
            ->withSum('vendorOrders as revenue', 'sub_total')
            ->orderByDesc('revenue')
            ->limit($limit)
            ->get();
    }
}
