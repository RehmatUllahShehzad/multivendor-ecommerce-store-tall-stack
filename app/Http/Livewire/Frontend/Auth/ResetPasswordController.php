<?php

namespace App\Http\Livewire\Frontend\Auth;

use App\Models\User;
use App\Rules\PasswordValidator;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ResetPasswordController extends Component
{
    public string $token;

    public string $email;

    public string $password = '';

    public string $confirm_password = '';

    /**
     * @var array<mixed>
     */
    protected $messages = [
        'email.exists' => 'No account found with given email',
    ];

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request('email', '');
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'bail|required|email:filter,rfc,dns|exists:users,email',
            'password' => [
                'required',
                'min:8',
                new PasswordValidator(
                    User::whereEmail($this->email)->firstOrFail(),
                    true
                ),
            ],
            'confirm_password' => 'required|same:password',
        ];
    }

    public function render(): View
    {
        return view('frontend.auth.reset-password-controller')->layout(MasterLayout::class, [
            'title' => trans('global.reset_password.title'),
            'description' => trans('global.reset_password.title'),
            'keywords' => '',
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->confirm_password,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('alert-success', trans('notifications.password-reset.password_updated'));
            Auth::logout();
            $this->email = '';
            $this->password = '';
            $this->confirm_password = '';

            return to_route('login');
        }

        $this->emit('alert-danger', __($status));
    }
}
