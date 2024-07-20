<?php

namespace App\Services\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;

class PermissionProviderService
{
    /**
     * @var array<mixed>
     */
    private array $configPermissions;

    private Collection $dataBasePermissions;

    public function __construct()
    {
        $this->configPermissions = config('admin.permissions', []);
        $this->dataBasePermissions = $this->getDbToConfigMappedPermissions();
    }

    public static function make(): self
    {
        return new self();
    }

    public function registerAllPermissions(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->clearCachedPermissions();

        $permissions = collect($this->configPermissions);

        foreach ($permissions as $permission) {
            Permission::firstOrNew([
                'name' => $permission['handle'],
                'guard_name' => 'admin',
            ])->fill([
                'name' => $permission['handle'],
                'guard_name' => 'admin',
            ])->save();
        }
    }

    /**
     * Returns permissions grouped by their handle
     * For example, settings:channel would become a child of settings.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getGroupedPermissions(): Collection
    {
        $permissions = $this->dataBasePermissions;

        foreach ($permissions as $key => $permission) {
            $parent = $this->getParentPermission($permission);

            if ($parent) {
                $parent->children->push($permission); /** @phpstan-ignore-line */
                $permissions->forget($key);
            }
        }

        return $permissions;
    }

    /**
     * Returns the parent permission based on handle naming.
     *
     * @param  Permission  $permission
     * @return \Spatie\Permission\Models\Permission | void;
     */
    protected function getParentPermission($permission)
    {
        $crumbs = explode(':', $permission->handle); /** @phpstan-ignore-line */
        if (empty($crumbs[1])) {
            return;
        }

        return $this->dataBasePermissions->first(fn ($parent) => $parent['handle'] === $crumbs[0]);
    }

    protected function getDbToConfigMappedPermissions(): Collection
    {
        return $this->getCachedPermissions()->map(function (Permission $permission) {
            $permission->children = collect(); /** @phpstan-ignore-line */
            $permission->handle = $permission->name; /** @phpstan-ignore-line */
            $configPermission = collect($this->configPermissions)->first(fn ($perm) => $perm['handle'] == $permission->name); /** @phpstan-ignore-line */
            if ($configPermission) {
                $permission->name = $configPermission['name']; /** @phpstan-ignore-line */
                $permission->description = $configPermission['description']; /** @phpstan-ignore-line */

                return $permission;
            }

            $permission->delete();
            $this->updateCachedPermissions();
        })->filter();
    }

    public function getCachedPermissions(): Collection
    {
        return Cache::rememberForever('database-permissions', function () {
            return Permission::query()->select('name')->get();
        });
    }

    public function clearCachedPermissions(): self
    {
        Cache::forget('database-permissions');

        return $this;
    }

    public function updateCachedPermissions(): self
    {
        $this->clearCachedPermissions();
        $this->getCachedPermissions();

        return $this;
    }
}
