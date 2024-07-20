<?php

namespace App\Http\Livewire\Admin\Profile;

use App\Http\Livewire\Admin\System\Staff\StaffAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\View\Components\Admin\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffProfileController extends StaffAbstract
{
    use Notifies;

    public string $currentPassword = '';

    public function mount(): void
    {
        /** @phpstan-ignore-next-line */
        $this->staff = Auth::user();
    }

    /**
     * Define the validation rules.
     *
     * @return array<string, mixed>
     */
    protected function rules()
    {
        return [
            'staff.email' => 'required|email|max:50|unique:'.get_class($this->staff).',email,'.$this->staff->id,
            'staff.first_name' => 'required|max:30',
            'staff.last_name' => 'required|max:30',
            'password' => 'nullable|min:8|max:255',
            'currentPassword' => ['nullable', 'required_with:password', function ($attribute, $value, $fail) {
                if ($this->password && ! Hash::check($value, $this->staff->password)) {
                    return $fail(trans('validation.current_password'));
                }
            }],
        ];
    }

    public function render(): View
    {
        return view('admin.profile.staff-profile-controller')->layout(MasterLayout::class, [
            'title' => 'Profile',
            'description' => 'Profile',
        ]);
    }

    public function update(): void
    {
        $this->validate();

        if ($this->staff->id != Auth::id()) {
            abort(401);
        }

        if ($this->password) {
            $this->staff->password = Hash::make($this->password);
        }

        $this->staff->save();

        $this->notify(trans('notifications.profile.updated'));
    }
}
