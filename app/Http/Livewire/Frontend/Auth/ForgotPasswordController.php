<?php

namespace App\Http\Livewire\Frontend\Auth;

use App\View\Components\Frontend\Layouts\MasterLayout;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPasswordController extends Component
{
    public string $email;

    public function mount(): void
    {
        $this->email = '';
    }

    public function render(): View
    {
        return view('frontend.auth.forgot-password-controller')->layout(MasterLayout::class, [
            'title' => trans('global.fogot_password.title'),
            'description' => trans('global.fogot_password.title'),
            'keywords' => '',
        ]);
    }

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => 'required|exists:users,email|email:filter,rfc,dns',
        ]);

        try {
            $response = Password::broker()->sendResetLink([
                'email' => $this->email,
                'is_active' => true,
            ]);

            throw_if(
                $response == Password::INVALID_USER,
                Exception::class,
                'Account not found or has been disabled.'
            );

            throw_if(
                $response != Password::RESET_LINK_SENT,
                Exception::class,
                'Unable to send password reset email.'
            );

            $this->emit('alert-success', trans('notifications.password-reset.email_sent'));
            $this->email = '';
        } catch (Exception $ex) {
            $this->emit('alert-danger', $ex->getMessage());
        }
    }
}
