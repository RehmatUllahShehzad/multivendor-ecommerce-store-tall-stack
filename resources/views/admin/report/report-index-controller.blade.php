<div>
    
    @include('admin.report._partials.top_ten_products')

    @include('admin.report._partials.most_viewed_products')

    @include('admin.report._partials.last_ten_orders')
    
    @include('admin.report._partials.top_ten_customers', ['users' => $topTenCustomers, 'type' => 'customers'])

    @include('admin.report._partials.top_ten_customers', ['users' => $topTenVendors, 'type' => 'vendors'])

</div>
