<?php

namespace App\Http\Livewire\Frontend\Vendor;

use App\Http\Livewire\Frontend\VendorAbstract;
use App\Models\Vendor;
use App\Rules\Frontend\Vendor\Address;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfileController extends VendorAbstract
{
    use WithFileUploads;

    public Vendor $vendor;

    public TemporaryUploadedFile|Media|string|null $profileImage = null;

    public TemporaryUploadedFile|Media|string|null $bannerImage = null;

    protected $validationAttributes = ['company_address_components' => 'address'];

    public function mount(): void
    {
        $this->vendor = Auth::user()->vendor;

        $this->profileImage = $this->vendor->getFirstMedia('avatar');

        $this->bannerImage = $this->vendor->getFirstMedia('banner');
    }

    public function getMediaModel(): Authenticatable
    {
        return Auth::user();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        $rules = [
            'vendor.vendor_name' => 'required|max:30',
            'vendor.company_name' => 'required|max:191',
            'vendor.bio' => 'required|max:500',
            'vendor.company_phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
            'vendor.company_address_components' => [new Address()],
            'vendor.deliver_products' => 'required|boolean',
            'vendor.deliver_up_to_max_miles' => $this->vendor->deliver_products ? 'numeric|gt:0' : '',
            'vendor.express_delivery_rate' => $this->vendor->deliver_products ? 'numeric|gt:0' : '',
            'vendor.standard_delivery_rate' => $this->vendor->deliver_products ? 'numeric|gt:0' : '',
            'profileImage' => 'required',
            'bannerImage' => 'nullable',
        ];

        return $rules;
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.profile-controller');
    }

    public function getProfileImagePreviewProperty(): string|null
    {
        if (! $this->profileImage) {
            return null;
        }

        $method = $this->profileImage instanceof Media ? 'getFullUrl' : 'temporaryUrl';

        return $this->profileImage->{$method}();
    }

    public function getBannerImagePreviewProperty(): string|null
    {
        if (! $this->bannerImage) {
            return null;
        }

        $method = $this->bannerImage instanceof Media ? 'getFullUrl' : 'temporaryUrl';

        return $this->bannerImage->{$method}();
    }

    public function removeProfileImage(): void
    {
        if ($this->profileImage instanceof TemporaryUploadedFile) {
            $this->profileImage->delete();
        }

        $this->profileImage = null;
    }

    public function removeBannerImage(): void
    {
        if ($this->bannerImage instanceof TemporaryUploadedFile) {
            $this->bannerImage->delete();
        }

        $this->bannerImage = null;
    }

    public function submit(): void
    {
        $this->vendor->company_phone = preg_replace('/[^0-9]/', '', $this->vendor->company_phone);

        $this->validate();

        if (! $this->bannerImage) {
            $this->vendor->clearMediaCollection('banner');
        }

        if ($this->profileImage instanceof TemporaryUploadedFile) {
            $this->vendor->clearMediaCollection('avatar');
            $this->vendor->addMedia($this->profileImage->getRealPath())
                ->usingName($this->profileImage->getClientOriginalName())
                ->toMediaCollection('avatar');

            $this->profileImage = $this->vendor->getFirstMedia('avatar');
        }

        if ($this->bannerImage instanceof TemporaryUploadedFile) {
            $this->vendor->clearMediaCollection('banner');
            $this->vendor->addMedia($this->bannerImage->getRealPath())
                ->usingName($this->bannerImage->getClientOriginalName())
                ->toMediaCollection('banner');

            $this->bannerImage = $this->vendor->getFirstMedia('banner');
        }

        $this->vendor->save();

        $this->emit('alert-success', trans('notifications.profile.updated'));
    }
}
