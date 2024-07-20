<?php

namespace Tests\Feature\Admin;

use App\Facades\SettingFacade;
use App\Http\Livewire\Admin\System\Setting\SettingIndexController;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class SettingTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_settings_page()
    {
        $response = $this->get(
            route('admin.system.setting.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_can_see_settings_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.system.setting.index')
        );

        $response->assertOk();
    }

    public function test_authorized_users_can_update_settings_with_valid_data()
    {
        $this->loginStaff(true);

        $settings = [
            'settings.site_title' => 'PP',
            'settings.meta_tag' => 'meta tag',
            'settings.copyright_text' => 'PP, Inc.',
            'settings.service_fee' => 4,
            'settings.phone' => '0123456789',
            'settings.order_payment_processing_time' => 2,
            'settings.contact_us_email' => 'abc@gmail.com',
            'settings.information_email' => 'def@gmail.com',
            'settings.address' => 'Adipisicing quod amet accusamus adipisicing rerum',
            'settings.facebook_url' => 'https://www.facebook.com/',
            'settings.twitter_url' => 'https://www.twitter.com/',
            'settings.instagram_url' => 'https://www.instagram.com/',
            'smallImage' => UploadedFile::fake()->image('avatar.jpg'),
            'fullImage' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = Livewire::test(SettingIndexController::class)
            ->set($settings, SettingFacade::set($settings))
            ->call('submit');

        $response->assertOk();

        $this->assertCount(15, SettingFacade::all());
    }

    public function test_authorized_users_cannot_update_settings_with_invalid_data()
    {
        $this->loginStaff(true);

        $settings = [
            'settings.site_title' => '',
            'settings.service_fee' => '',
            'settings.order_payment_processing_time' => 'dsdsf',
            'settings.contact_us_email' => '',
            'settings.information_email' => '',
            'settings.instagram_url' => 'loremipsum',
            'settings.twitter_url' => 'url generated',
            'settings.facebook_url' => 'facebook url',
            'smallImage' => null,
            'fullImage' => null,
        ];

        $response = Livewire::test(SettingIndexController::class)
            ->set($settings, SettingFacade::set($settings))
            ->call('submit');

        $response->assertOk();

        $response->assertHasErrors([
            'settings.site_title',
            'settings.service_fee',
            'settings.order_payment_processing_time',
            'settings.contact_us_email',
            'settings.information_email',
            'settings.instagram_url',
            'settings.twitter_url',
            'settings.facebook_url',
            'smallImage',
            'fullImage',
        ]);
    }
}
