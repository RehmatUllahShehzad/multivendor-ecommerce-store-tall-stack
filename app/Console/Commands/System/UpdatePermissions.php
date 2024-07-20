<?php

namespace App\Console\Commands\System;

use App\Services\Admin\PermissionProviderService;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:update-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Permissions from configuration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating Permissions');
        PermissionProviderService::make()->registerAllPermissions();

        /** @var \Spatie\Permission\Models\Role */
        $role = Role::findOrCreate('SuperAdmin', 'admin');
        $role->save();

        $this->info('Permissions Updated');

        return 0;
    }
}
