<?php

namespace App\Http\Livewire\Admin\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;

class LogoutController extends Component
{
    public bool $isSideBar;

    public function render(): View
    {
        return view('admin.auth.logout-controller');
    }

    public function logout(): Redirector | RedirectResponse
    {
        Auth::logout();
        session()->regenerate();

        return to_route('admin.login');
    }
}
