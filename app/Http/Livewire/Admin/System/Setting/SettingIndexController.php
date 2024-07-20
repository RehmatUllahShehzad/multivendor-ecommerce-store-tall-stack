<?php

namespace App\Http\Livewire\Admin\System\Setting;

use App\Facades\SettingFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class SettingIndexController extends SettingAbstract
{
    public array $settings = [];

    private string $logoPath = 'settings';

    public TemporaryUploadedFile|string|null $smallImage = null;

    public TemporaryUploadedFile|string|null $fullImage = null;

    protected function rules()
    {
        return [
            'settings.site_title' => 'required|string|max:255',
            'settings.meta_tag' => 'string|max:255',
            'settings.copyright_text' => 'string|max:255',
            'settings.service_fee' => 'required|numeric|max:100',
            'settings.phone' => 'string|max:255',
            'settings.order_payment_processing_time' => 'required|numeric',
            'settings.contact_us_email' => 'required|email|max:255',
            'settings.information_email' => 'required|email|max:255',
            'settings.address' => 'string|max:255',
            'settings.facebook_url' => ['regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', 'max:255'],
            'settings.twitter_url' => ['regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', 'max:255'],
            'settings.instagram_url' => ['regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', 'max:255'],
            'smallImage' => is_string($this->smallImage) ? '' : 'image|required',
            'fullImage' => is_string($this->fullImage) ? '' : 'image|required',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'settings.site_title' => 'site title',
            'settings.meta_tag' => 'meta tag',
            'settings.copyright_text' => 'copyright text',
            'settings.phone' => 'phone',
            'settings.service_fee' => 'service fee',
            'settings.contact_us_email' => 'contact email',
            'settings.information_email' => 'informational email',
            'settings.address' => 'address',
            'settings.order_payment_processing_time' => 'order payment processing time',
            'settings.facebook_url' => 'facebook url',
            'settings.twitter_url' => 'twitter url',
            'settings.instagram_url' => 'instagram url',
        ];
    }

    public function mount()
    {
        $this->settings = SettingFacade::all();

        $this->smallImage = optional($this->settings)['smallImage'];

        $this->fullImage = optional($this->settings)['fullImage'];
    }

    public function render(): View
    {
        return $this->view('admin.system.setting.setting-index-controller');
    }

    public function getSmallImagePreviewProperty(): string|null
    {
        if (! $this->smallImage) {
            return null;
        }

        if ($this->smallImage instanceof TemporaryUploadedFile) {
            return $this->smallImage->temporaryUrl();
        }

        return $this->smallImage;
    }

    public function getFullImagePreviewProperty(): string|null
    {
        if (! $this->fullImage) {
            return null;
        }

        if ($this->fullImage instanceof TemporaryUploadedFile) {
            return $this->fullImage->temporaryUrl();
        }

        return $this->fullImage;
    }

    public function removeSmallImage(): void
    {
        if ($this->smallImage instanceof TemporaryUploadedFile) {
            $this->smallImage->delete();
        }

        $this->smallImage = null;
    }

    public function removeFullImage(): void
    {
        if ($this->fullImage instanceof TemporaryUploadedFile) {
            $this->fullImage->delete();
        }

        $this->fullImage = null;
    }

    public function submit()
    {
        $this->validate();

        if ($this->smallImage instanceof TemporaryUploadedFile) {
            $this->smallImage->storePubliclyAs($this->logoPath, 'small-logo.'.$this->smallImage->getClientOriginalExtension(), config('media-library.disk_name'));
            $this->settings['smallImage'] = Storage::disk(config('media-library.disk_name'))->url($this->logoPath.'/small-logo.'.$this->smallImage->getClientOriginalExtension());
        }

        if ($this->fullImage instanceof TemporaryUploadedFile) {
            $this->fullImage->storePubliclyAs($this->logoPath, 'full-logo.'.$this->fullImage->getClientOriginalExtension(), config('media-library.disk_name'));
            $this->settings['fullImage'] = Storage::disk(config('media-library.disk_name'))->url($this->logoPath.'/full-logo.'.$this->fullImage->getClientOriginalExtension());
        }

        SettingFacade::set($this->settings);

        $this->notify(trans('notifications.settings.updated'));
    }
}
