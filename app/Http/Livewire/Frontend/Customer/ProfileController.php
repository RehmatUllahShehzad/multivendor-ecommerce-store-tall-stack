<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends UserAbstract
{
    public User $user;

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'user.username' => 'required|max:30|unique:users,username,'.$this->user->id,
            'user.first_name' => 'required|max:30',
            'user.last_name' => 'required|max:30',
            'user.email' => 'nullable',
        ];
    }

    public function render(): View
    {
        return $this->view('frontend.customer.profile-controller');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function submit()
    {
        if (! $this->user instanceof User || ! $this->user->isActive()) {
            Auth::logout();

            return redirect()->route('login');
        }

        $this->validate();

        $this->user->save();

        $this->emit('alert-success', trans('notifications.profile_updated'));
    }
}
