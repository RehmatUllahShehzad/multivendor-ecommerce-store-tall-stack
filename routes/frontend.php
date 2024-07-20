<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Livewire\Frontend\Customer\Addresses\AddressIndexController;
use App\Http\Livewire\Frontend\Customer\Addresses\AddressShowController;
use App\Http\Livewire\Frontend\Customer\Addresses\CreateAddressController;
use App\Http\Livewire\Frontend\Customer\Dashboard;
use App\Http\Livewire\Frontend\Customer\LoginSecurity;
use App\Http\Livewire\Frontend\Customer\Message\MessageIndexController as CustomerMessageIndexController;
use App\Http\Livewire\Frontend\Customer\Message\MessageShowController as CustomerMessageShowController;
use App\Http\Livewire\Frontend\Customer\Orders\OrderIndexController;
use App\Http\Livewire\Frontend\Customer\Orders\OrderShowController;
use App\Http\Livewire\Frontend\Customer\PaymentMethods\PaymentMethodCreateController;
use App\Http\Livewire\Frontend\Customer\PaymentMethods\PaymentMethodIndexController;
use App\Http\Livewire\Frontend\Customer\ProfileController;
use App\Http\Livewire\Frontend\Vendor\Dashboard as VendorDashboard;
use App\Http\Livewire\Frontend\Vendor\Message\MessageIndexController;
use App\Http\Livewire\Frontend\Vendor\Message\MessageShowController;
use App\Http\Livewire\Frontend\Vendor\Orders\OrderIndexController as VendorOrderIndexController;
use App\Http\Livewire\Frontend\Vendor\Orders\OrderShowController as VendorOrderShowController;
use App\Http\Livewire\Frontend\Vendor\PaymentHistory\AttachAccountController;
use App\Http\Livewire\Frontend\Vendor\PaymentHistory\AttachBankAccountController;
use App\Http\Livewire\Frontend\Vendor\PaymentHistory\AttachDebitCardController;
use App\Http\Livewire\Frontend\Vendor\PaymentHistory\PaymentHistoryIndexController;
use App\Http\Livewire\Frontend\Vendor\Product\ProductCreateController;
use App\Http\Livewire\Frontend\Vendor\Product\ProductEditController;
use App\Http\Livewire\Frontend\Vendor\Product\ProductIndexController;
use App\Http\Livewire\Frontend\Vendor\ProfileController as FrontendVendorProfileController;
use App\Http\Livewire\Frontend\Vendor\Review\ReviewIndexController;
use App\Http\Livewire\Frontend\Vendor\Review\ReviewShowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'auth.active')->group(function () {

    Route::prefix('customer')->as('customer.')->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('profile', ProfileController::class)->name('profile');
        Route::get('address', AddressIndexController::class)->name('addresses.index');
        Route::get('address/create', CreateAddressController::class)->name('addresses.create');
        Route::get('address/{address}', AddressShowController::class)->name('addresses.show');
        Route::get('payment-method', PaymentMethodIndexController::class)->name('payment.index');
        Route::get('payment-method/create', PaymentMethodCreateController::class)->name('payment.create');
        Route::get('login-security', LoginSecurity::class)->name('login.security');
        Route::get('order', OrderIndexController::class)->name('orders.index');
        Route::get('order/{order}', OrderShowController::class)->name('orders.show');
        Route::get('messages', CustomerMessageIndexController::class)->name('messages');
        Route::get('messages/{orderPackage}', CustomerMessageShowController::class)->name('message.show');
    });

    Route::middleware('auth.vendor')->prefix('vendor')->as('vendor.')->group(function () {
        Route::get('dashboard', VendorDashboard::class)->name('dashboard');
        Route::get('product', ProductIndexController::class)->name('product.index');
        Route::get('product/create', ProductCreateController::class)->name('product.create');
        Route::get('product/{product}', ProductEditController::class)->name('product.edit');
        Route::get('messages', MessageIndexController::class)->name('messages');
        Route::get('messages/{orderPackage}', MessageShowController::class)->name('message.show');

        Route::get('profile', FrontendVendorProfileController::class)->name('profile');
        Route::get('orders', VendorOrderIndexController::class)->name('orders');
        Route::get('orders/{order}', VendorOrderShowController::class)->name('orders.show');

        Route::get('payment/history', PaymentHistoryIndexController::class)->name('payment.history.index');
        Route::get('attach/account', AttachAccountController::class)->name('attach.account');
        Route::get('attach/debit/card', AttachDebitCardController::class)->name('attach.debit.card');
        Route::get('attach/bank/account', AttachBankAccountController::class)->name('attach.bank.account');

        Route::get('reviews', ReviewIndexController::class)->name('reviews');
        Route::get('review/{review}', ReviewShowController::class)->name('review.show');
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::any('/{page:slug}', PageController::class)->name('page');
