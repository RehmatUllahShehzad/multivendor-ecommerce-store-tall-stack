<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Livewire\Frontend\Cart\CartIndexController;
use App\Http\Livewire\Frontend\Cart\Checkout\AddressController;
use App\Http\Livewire\Frontend\Cart\Checkout\PaymentController;
use App\Http\Livewire\Frontend\Cart\Checkout\PlaceOrderController;
use App\Http\Livewire\Frontend\Cart\Checkout\ThankyouController;
use App\Http\Livewire\Frontend\Products\ProductIndexController;
use App\Http\Livewire\Frontend\Products\ProductShowController;
use App\Http\Livewire\Frontend\Vendor\ProfileShowController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('profile/{vendor:vendor_slug}', ProfileShowController::class)->name('vendor-profile');

Route::get('product-listing', ProductIndexController::class)->name('products.index');
Route::get('product-detail/{product:slug}', ProductShowController::class)->name('products.show');

Route::as('checkout.')->prefix('checkout')->group(function () {

    Route::get('cart', CartIndexController::class)->name('cart');

    Route::middleware('auth')->group(function () {
        Route::get('shipping', AddressController::class)->name('shipping');
        Route::get('billing', AddressController::class)->name('billing');
        Route::get('payment', PaymentController::class)->name('payment');
        Route::get('confirmation', PlaceOrderController::class)->name('place-order');
        Route::get('thankyou', ThankyouController::class)->name('thankyou');

    });

});

Route::get('/', PageController::class)->name('homepage');
