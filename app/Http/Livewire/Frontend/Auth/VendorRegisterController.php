<?php

namespace App\Http\Livewire\Frontend\Auth;

use App\Enums\VendorStatus;
use App\Mail\NewVendorAccountRequested;
use App\Models\VendorRequest;
use App\Rules\Frontend\Vendor\Address;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VendorRegisterController extends Component
{
    public string $bio;

    public string $company_name;

    public string $vendor_name;

    public string $company_phone;

    public array $company_address_components = [];

    protected $validationAttributes = ['company_address_components' => 'address'];

    public function mount(): void
    {
        $this->initializeFields();

        abort_if(! Auth::check(), 401);
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        $this->company_phone = preg_replace('/[^0-9]/', '', $this->company_phone);

        return [
            'vendor_name' => 'required|max:30',
            'company_name' => 'required|max:191',
            'bio' => 'required|max:500',
            'company_phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
            'company_address_components' => [new Address()],
        ];
    }

    public function render(): View
    {
        return view('frontend.auth.vendor-register-controller')->layout(MasterLayout::class, [
            'title' => trans('global.vendor_signup.title'),
            'description' => trans('global.vendor_signup.title'),
            'keywords' => '',
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function register()
    {
        $data = $this->validate();

        $user = Auth::user();

        $vendorRequest = VendorRequest::create([
            'user_id' => $user->id,
            'status' => VendorStatus::Pending,
            'extra_data' => $data,
        ]);

        $vendorRequest->setStatus(VendorStatus::Pending);

        try {
            Mail::send(new NewVendorAccountRequested($user));
            Mail::send(new NewVendorAccountRequested($user, true));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        session()->flash('alert-success', trans('notifications.vendor_request'));

        return to_route('customer.dashboard');
    }

    public function initializeFields(): void
    {
        $this->bio = '';
        $this->vendor_name = '';
        $this->company_phone = '';
        $this->company_address_components = [];
        $this->company_name = '';
    }
}
