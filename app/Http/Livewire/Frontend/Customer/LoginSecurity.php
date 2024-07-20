<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Rules\PasswordValidator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginSecurity extends UserAbstract
{
    public string $current_password;

    public string $new_password;

    public string $confirm_password;

    public function mount(): void
    {
        $this->initializeFields();
    }

    public function render(): View
    {
        return $this->view('frontend.customer.login-security');
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        $value = $this->current_password;

        return [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (! Hash::check($value, Auth::user()->password)) {
                    return $fail(trans('validation.current_password'));
                }
            }],
            'new_password' => [
                'required',
                'min:8',
                new PasswordValidator(
                    Auth::user(),
                    true
                ),
            ],
            'confirm_password' => 'required|min:8|same:new_password',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        Auth::user()->update([
            'password' => bcrypt($this->new_password),
        ]);

        $this->emit('alert-success', trans('notifications.password_updated'));

        $this->initializeFields();
    }

    public function initializeFields(): void
    {
        $this->current_password = '';
        $this->new_password = '';
        $this->confirm_password = '';
    }
}
