<?php

namespace Tests\Feature\Frontend\Auth;

use App\Http\Livewire\Frontend\Auth\ForgotPasswordController;
use App\Http\Livewire\Frontend\Auth\ResetPasswordController;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        $user = User::factory()->create();

        $response = Livewire::test(ForgotPasswordController::class)
            ->set('email', $user->email)
            ->call('sendPasswordResetLink');

        $response->assertStatus(200);
    }

    public function test_reset_passwod_notification_can_be_sent(): void
    {
        Notification::fake();

        $email = Str::random().'@gmail.com';

        $current_password = Str::random(16);

        $current_password_hash = Hash::make($current_password);

        $user = User::factory()->create([
            'email' => $email,
            'password' => $current_password_hash,
        ]);

        $response = Livewire::test(ForgotPasswordController::class)
            ->set('email', $user->email)
            ->call('sendPasswordResetLink');

        $response->assertStatus(200);
        Notification::assertSentTo($user, ResetPassword::class);

    }

    public function test_password_can_be_reset_with_valid_token(): void
    {

        Notification::fake();

        $email = Str::random().'@gmail.com';

        $current_password = Str::random(16);

        $current_password_hash = Hash::make($current_password);

        $user = User::factory()->create([
            'email' => $email,
            'password' => $current_password_hash,
        ]);

        Livewire::test(ForgotPasswordController::class)
            ->set('email', $user->email)
            ->call('sendPasswordResetLink');

        Notification::assertSentTo($user, ResetPassword::class);

        $userToken = DB::select('select * from password_resets');

        $token = $userToken[0]->token;

        $response = Livewire::test(ResetPasswordController::class, ['token' => $token])
            ->set('token', $token)
            ->set('email', $user->email)
            ->set('password', '12345678')
            ->set('confirm_password', '12345678')
            ->call('resetPassword');

        $response->assertStatus(200);
    }
}
