<?php

namespace App\Http\Livewire\Frontend\Auth;

use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginController extends Component
{
    public string $email;

    public string $password;

    public function mount(): void
    {
        $this->resetFields();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function render(): View
    {
        return view('frontend.auth.login-controller')->layout(MasterLayout::class, [
            'title' => trans('global.login.title'),
            'description' => trans('global.login.title'),
            'keywords' => '',
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function login()
    {
        $this->validate();

        if (! Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password, 'is_active' => true])) {
            $this->addError('email', 'Invalid Credentials');

            return;
        }

        session()->regenerate();

        return redirect()->intended($this->redirect ?? route('vendor.dashboard'));
    }

    public function resetFields(): void
    {
        $this->email = '';
        $this->password = '';
    }
}
