<?php

use App\Http\Livewire\Admin\Auth\LoginController;
use App\Http\Livewire\Admin\Auth\PasswordResetController;
use App\Http\Livewire\Frontend\Auth\ForgotPasswordController;
use App\Http\Livewire\Frontend\Auth\LoginController as FrontendLoginController;
use App\Http\Livewire\Frontend\Auth\RegisterController;
use App\Http\Livewire\Frontend\Auth\ResetPasswordController;
use App\Http\Livewire\Frontend\Auth\VendorRegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::middleware('guest.admin:admin')->group(function () {
        Route::get('login', LoginController::class)->name('login');
        Route::get('password-reset', PasswordResetController::class)->name('password-reset');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('register', RegisterController::class)->name('register');

    Route::get('login', FrontendLoginController::class)->name('login');

    Route::get('forgot-password', ForgotPasswordController::class)->name('password.request');

    Route::get('reset-password/{token}', ResetPasswordController::class)->name('password.reset');
});

Route::middleware('auth', 'auth.active', 'guest.vendor')->group(function () {
    Route::get('vendor/register', VendorRegisterController::class)->name('register.vendor');
});
