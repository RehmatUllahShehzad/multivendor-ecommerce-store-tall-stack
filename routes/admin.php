<?php

use App\Http\Controllers\Admin\EditorController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryCreateController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryIndexController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryShowController;
use App\Http\Livewire\Admin\Catalog\DietaryRistrictions\DietaryCreateController;
use App\Http\Livewire\Admin\Catalog\DietaryRistrictions\DietaryIndexController;
use App\Http\Livewire\Admin\Catalog\DietaryRistrictions\DietaryShowController;
use App\Http\Livewire\Admin\Catalog\Nutrition\NutritionCreateController;
use App\Http\Livewire\Admin\Catalog\Nutrition\NutritionIndexController;
use App\Http\Livewire\Admin\Catalog\Nutrition\NutritionShowController;
use App\Http\Livewire\Admin\Catalog\Product\ProductIndexController;
use App\Http\Livewire\Admin\Catalog\Product\ProductShowController;
use App\Http\Livewire\Admin\Cms\Menu\MenuBuilderController;
use App\Http\Livewire\Admin\Cms\Menu\MenuController;
use App\Http\Livewire\Admin\Customer\CustomerIndexController;
use App\Http\Livewire\Admin\Customer\CustomerShowController;
use App\Http\Livewire\Admin\Dashboard\DashboardController;
use App\Http\Livewire\Admin\Form\FormIndexController;
use App\Http\Livewire\Admin\Form\FormShowController;
use App\Http\Livewire\Admin\Order\OrderIndexController;
use App\Http\Livewire\Admin\Order\OrderShowController;
use App\Http\Livewire\Admin\Pages\PageCreateController;
use App\Http\Livewire\Admin\Pages\PageIndexController;
use App\Http\Livewire\Admin\Pages\PageShowController;
use App\Http\Livewire\Admin\Profile\StaffProfileController;
use App\Http\Livewire\Admin\Report\ReportIndexController;
use App\Http\Livewire\Admin\System\Setting\SettingIndexController;
use App\Http\Livewire\Admin\System\Staff\StaffCreateController;
use App\Http\Livewire\Admin\System\Staff\StaffIndexController;
use App\Http\Livewire\Admin\System\Staff\StaffShowController;
use App\Http\Livewire\Admin\System\Unit\UnitCreateController;
use App\Http\Livewire\Admin\System\Unit\UnitIndexController;
use App\Http\Livewire\Admin\System\Unit\UnitShowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.admin:admin')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('catalog')->middleware('permission:catalog')->as('catalog.')->group(function () {
        Route::middleware('permission:catalog:manage-catalog')->group(function () {
            Route::get('nutrition', NutritionIndexController::class)->name('nutrition.index');
            Route::get('nutrition/create', NutritionCreateController::class)->name('nutrition.create');
            Route::get('nutrition/{nutrition}', NutritionShowController::class)->name('nutrition.show');
        });

        Route::get('product', ProductIndexController::class)->name('product.index');
        Route::get('product/{product}', ProductShowController::class)->name('product.show');

        Route::get('category', CategoryIndexController::class)->name('category.index');
        Route::get('category/create', CategoryCreateController::class)->name('category.create');
        Route::get('category/{category}', CategoryShowController::class)->name('category.show');

        Route::get('dietry-restrictions', DietaryIndexController::class)->name('dietary.index');
        Route::get('dietry-restrictions/create', DietaryCreateController::class)->name('dietary.create');
        Route::get('dietry-restrictions/{dietaryRistriction}', DietaryShowController::class)->name('dietary.show');

    });

    Route::middleware('permission:manage-customers')->group(function () {
        Route::get('customer', CustomerIndexController::class)->name('customer.index');
        Route::get('customer/{customer}', CustomerShowController::class)->name('customer.show');
    });

    Route::middleware('permission:manage-orders')->group(function () {
        Route::get('order', OrderIndexController::class)->name('order.index');
        Route::get('order/{order}', OrderShowController::class)->name('order.show');
    });

    Route::get('reports', ReportIndexController::class)->name('reports.index');

    Route::prefix('system')->middleware('permission:system')->as('system.')->group(function () {
        Route::middleware('permission:system:manage-staff')->group(function () {
            Route::get('staff', StaffIndexController::class)->name('staff.index');
            Route::get('staff/create', StaffCreateController::class)->name('staff.create');
            Route::get('staff/{staff}', StaffShowController::class)->name('staff.show');
        });

        Route::middleware('permission:system:manage-units')->group(function () {
            Route::get('unit', UnitIndexController::class)->name('unit.index');
            Route::get('unit/create', UnitCreateController::class)->name('unit.create');
            Route::get('unit/{unit}', UnitShowController::class)->name('unit.show');
        });

        Route::middleware('permission:system-settings')->group(function () {
            Route::get('setting', SettingIndexController::class)->name('setting.index');
        });
    });

    Route::middleware('permission:pages')->group(function () {
        Route::get('pages', PageIndexController::class)->name('pages.index');
        Route::get('pages/create', PageCreateController::class)->name('pages.create');
        Route::get('pages/{page}/show', PageShowController::class)->name('pages.show');
        Route::get('editor/{page}', [EditorController::class, 'index'])->name('editor.index');
        Route::post('editor/{page}', [EditorController::class, 'store'])->name('editor.store');
        Route::get('editor/{page}/templates', [EditorController::class, 'templates'])->name('editor.templates');
    });

    Route::middleware('permission:forms')->group(function () {
        Route::get('forms', FormIndexController::class)->name('forms.index');
        Route::get('forms/{form}/show', FormShowController::class)->name('forms.show');

    });

    Route::prefix('cms')->middleware('permission:cms')->as('cms.')->group(function () {
        Route::middleware('permission:cms:manage-menu')->group(function () {
            Route::get('menu', MenuController::class)->name('menu.index');
            Route::get('menus/{menu}/builder', MenuBuilderController::class)->name('menu.builder');
        });
    });

    Route::get('staff/account', StaffProfileController::class)->name('staff.profile');
});
