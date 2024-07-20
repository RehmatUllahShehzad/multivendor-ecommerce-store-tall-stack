<?php

namespace App\Services\Payments;

use App\Contracts\PaymentProcessor;
use App\DTO\Payments\PaymentMethod;
use App\Managers\PaymentManager;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodService
{
    private PaymentProcessor $provider;

    private Model $model;

    private User $user;

    private PaymentMethod $data;

    private bool $shouldUpdateOnProvider = true;

    private bool $attachToCustomer = false;

    private bool $isPrimary = false;

    public function __construct(PaymentManager $paymentManager)
    {
        $this->provider = $paymentManager->driver();
    }

    public static function makeFrom(PaymentMethod $paymentMethod): self
    {
        return (new self(app(PaymentManager::class)))->withData($paymentMethod);
    }

    public function withModel(Model $paymentMethod): self
    {
        $this->model = $paymentMethod;

        return $this;
    }

    public function withData(PaymentMethod $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function forUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setPrimary(bool $primary = false): self
    {
        $this->isPrimary = $primary;

        return $this;
    }

    public function shouldUpdateOnProvider(bool $create = true): self
    {
        $this->shouldUpdateOnProvider = $create;

        return $this;
    }

    public function shouldAttachToCustomer(bool $attach = true): self
    {
        $this->attachToCustomer = $attach;

        return $this;
    }

    public function create(): Model
    {
        if (! $this->user instanceof User) {
            throw new Exception('No user provided');
        }

        if (! $this->model instanceof Model) {
            throw new Exception('No eloquent model provided');
        }

        if ($this->shouldUpdateOnProvider) {

            $this->user->createStripeCustomer();

            $response = $this->provider->createPaymentMethod(
                $this->data,
                $this->attachToCustomer ? $this->user->stripe_customer_id : null
            );

            if (! $response->success) {
                throw new Exception($response->message);
            }

            /** @phpstan-ignore-next-line */
            $this->model->createFromDto($response->data);
        }

        if (! $this->shouldUpdateOnProvider) {
            /** @phpstan-ignore-next-line */
            $this->model->createFromDto($this->data);
        }

        /** @phpstan-ignore-next-line */
        $paymentMethodExist = $this->model->query()->ofUser($this->user)->first();

        if (! $paymentMethodExist || $this->isPrimary) {
            /** @phpstan-ignore-next-line */
            $this->model->is_primary = true;

            /** @phpstan-ignore-next-line */
            $this->model->query()->ofUser($this->user)
                ->update([
                    'is_primary' => false,
                ]);
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

        if ($this->shouldUpdateOnProvider) {
            $this->provider->deletePaymentMethod(
                /** @phpstan-ignore-next-line */
                $this->model->payment_method_id,
            );
        }

        if (
            /** @phpstan-ignore-next-line */
            $this->model->isPrimary() &&
            /** @phpstan-ignore-next-line */
            ! $this->model->query()
                ->ofUser($this->user)
                ->except([$this->model->id]) /** @phpstan-ignore-line */
                ->primary()
                ->exists()
        ) {
            throw new Exception(trans('notifications.primary.alert'));
        }

        return $this->model->delete();
    }
}
