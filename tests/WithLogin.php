<?php

namespace Tests;

use App\Models\Admin\Staff;
use App\Models\User;
use App\Models\VendorRequest;

trait WithLogin
{
    public function loginStaff(bool $isAdmin = true): Staff
    {
        $this->artisan('system:update-permissions');

        $factory = Staff::factory();

        if ($isAdmin) {
            $factory = $factory->admin();
        }

        /** @var \App\Models\Admin\Staff */
        $staff = $factory->create();

        $this->actingAs($staff, 'admin');

        return $staff;
    }

    public function loginUser(bool $isVendor = false): User
    {
        $factory = User::factory();

        if ($isVendor) {
            $factory = $factory->hasVendor()
                ->has(
                    VendorRequest::factory()->approved()
                );
        }

        /** @var \App\Models\User */
        $user = $factory->create();

        $this->actingAs($user);

        return $user;
    }
}
