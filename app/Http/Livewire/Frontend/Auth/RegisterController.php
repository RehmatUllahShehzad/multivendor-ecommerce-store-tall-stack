<?php

namespace App\Http\Livewire\Frontend\Auth;

use App\Mail\NewAccountRegistered;
use App\Models\User;
use App\Rules\PasswordValidator;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RegisterController extends Component
{
    public string $password;

    public User $user;

    public string $confirmPassword;

    public function mount(): void
    {
        $this->user = new User();

        $this->initializeFields();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'user.first_name' => 'required|regex:/^[a-zA-Z ]*$/|max:30',
            'user.last_name' => 'required|regex:/^[a-zA-Z ]*$/|max:30',
            'user.email' => 'required|max:50|email:filter,rfc,dns|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'max:30',
                new PasswordValidator(),
            ],
            'confirmPassword' => 'required|same:password',
        ];
    }

    public function render(): View
    {
        return view('frontend.auth.register-controller')->layout(MasterLayout::class, [
            'title' => trans('global.sign_up.title'),
            'description' => trans('global.sign_up.title'),
            'keywords' => '',
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function register()
    {
        $this->validate();

        $this->user->password = bcrypt($this->password);

        $this->user->save();

        event(new Registered($this->user));

        session()->flash('alert-success', trans('notifications.account_created'));
        try {
            Mail::send(new NewAccountRegistered($this->user));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        Auth::loginUsingId($this->user->id);

        return to_route('customer.dashboard');
    }

    public function initializeFields(): void
    {
        $this->password = '';
        $this->confirmPassword = '';
    }
}
