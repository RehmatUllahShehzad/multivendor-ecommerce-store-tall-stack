<?php

namespace App\Http\Livewire\Traits;

trait CanDeleteRecord
{
    /**
     * Defines the confirmation text when deleting a model.
     *
     * @var string|null
     */
    public ?string $deleteConfirm = null;

    public function getCanDeleteProperty(): bool
    {
        return  $this->deleteConfirm == $this->getCanDeleteConfirmationField();
    }

    abstract public function getCanDeleteConfirmationField(): string;

    abstract protected function delete(): void;
}
