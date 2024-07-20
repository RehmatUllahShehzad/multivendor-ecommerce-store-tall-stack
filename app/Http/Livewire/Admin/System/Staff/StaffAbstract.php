<?php

namespace App\Http\Livewire\Admin\System\Staff;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Staff;
use Illuminate\Support\Collection;

abstract class StaffAbstract extends SystemAbstract
{
    use Notifies;

    /**
     * The staff model for the staff member we want to show.
     *
     * @var \App\Models\Admin\Staff
     */
    public Staff $staff;

    /**
     * The current staff assigned permissions.
     *
     * @var Collection
     */
    public Collection $staffPermissions;

    /**
     * Set current Staff as Admin
     *
     * @var bool
     */
    public bool $isAdmin;

    /**
     * The new password for the staff member.
     *
     * @var string
     */
    public $password;

    /**
     * The password confirmation for the staff member.
     *
     * @var string
     */
    public $password_confirmation;

    /**
     * Listener for when password is updated.
     *
     * @return void
     */
    public function updatedPassword()
    {
        $this->validateOnly('password');
    }

    /**
     * Listener for when password confirmation is updated.
     *
     * @return void
     */
    public function updatedPasswordConfirmation()
    {
        $this->validateOnly('password');
    }

    /**
     * Toggle whether the staff member is an admin.
     *
     * @return void
     */
    public function toggleAdmin()
    {
        $this->isAdmin = ! (bool) $this->isAdmin;
    }

    /**
     * Sync the set permissions with the staff member.
     *
     * @return void
     */
    protected function syncPermissions()
    {
        $this->staff->syncPermissions(
            $this->staffPermissions->toArray()
        );
    }

    /**
     * Toggle a permission for a staff member.
     *
     * @param  string  $handle
     * @param  array<mixed>  $children
     * @return void
     */
    public function togglePermission($handle, $children = [])
    {
        $index = $this->staffPermissions->search($handle);

        if ($index !== false) {
            $this->removePermission($handle);
            foreach ($children as $child) {
                $this->removePermission($child);
            }

            return;
        }

        $this->addPermission($handle);
    }

    /**
     * Add a permission to the staff member.
     *
     * @param  string  $handle
     * @return void
     */
    public function addPermission($handle)
    {
        if ($this->staffPermissions->contains($handle)) {
            return;
        }
        $this->staffPermissions->push($handle)->flatten();
    }

    /**
     * Remove a permission from a staff member.
     *
     * @param  string  $handle
     * @return void
     */
    public function removePermission($handle)
    {
        /** @var int $index */
        $index = $this->staffPermissions->search($handle);
        $this->staffPermissions->splice($index, 1);
    }
}
