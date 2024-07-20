<?php

namespace App\Services\Addresses;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class AddressService
{
    private Model $model;

    private User $user;

    private bool $isPrimary = false;

    public static function makeFrom(Model $address): self
    {
        return (new self())->withModel($address);
    }

    public function forUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function withModel(Model $address): self
    {
        $this->model = $address;

        return $this;
    }

    public function setPrimary(bool $primary = false): self
    {
        $this->isPrimary = $primary;

        return $this;
    }

    public function save(): Model
    {
        if (! $this->user instanceof User) {
            throw new Exception('No user provided');
        }

        if (! $this->model instanceof Model) {
            throw new Exception('No eloquent model provided');
        }

        /** @phpstan-ignore-next-line */
        $addressExist = $this->model->query()->ofUser($this->user)->first();

        if (! $addressExist || $this->isPrimary) {
            /** @phpstan-ignore-next-line */
            $this->model->is_primary = true;

            /** @phpstan-ignore-next-line */
            $this->model->query()->ofUser($this->user)
                ->update([
                    'is_primary' => false,
                ]);
        }

        if (
            ! $this->isPrimary &&
            $this->model->id &&
            /** @phpstan-ignore-next-line */
            ! $this->model->query()
                ->ofUser($this->user)
                ->except([$this->model->id])
                /** @phpstan-ignore-line */
                ->primary()
                ->exists()
        ) {
            throw new Exception(trans('notifications.primary.alert'));
        }

        /** @phpstan-ignore-next-line */
        $this->model->user_id = $this->user->id;

        $this->model->save();

        return $this->model;
    }

    public function delete(): bool
    {
        /** @phpstan-ignore-next-line */
        if (! $this->model->user_id = $this->user->id) {
            throw new Exception('Unauthorized', 403);
        }

        if (
            /** @phpstan-ignore-next-line */
            $this->model->isPrimary() &&
            /** @phpstan-ignore-next-line */
            ! $this->model->query()
                ->ofUser($this->user)
                ->except([$this->model->id])
                /** @phpstan-ignore-line */
                ->primary()
                ->exists()
        ) {
            throw new Exception(trans('notifications.primary.alert'));
        }

        return $this->model->delete();
    }
}
