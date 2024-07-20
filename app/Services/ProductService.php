<?php

namespace App\Services;

use App\Models\User;
use App\Traits\WithSaveImages;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductService
{
    use WithSaveImages;

    private Model $model;

    private User $user;

    /**
     * @var array<mixed>
     */
    private array $categories = [];

    /**
     * @var array<mixed>
     */
    private array $dietaryRistrictions = [];

    /**
     * @var array<mixed>
     */
    private array $images = [];

    private collection $nutritions;

    public static function makeFrom(Model $product): self
    {
        return (new self())->withModel($product);
    }

    public function forUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function withModel(Model $product): self
    {
        $this->model = $product;

        return $this;
    }

    public function getMediaModel(): Model
    {
        return $this->model;
    }

    public function withNutrition(Collection $nutritions = null): self
    {
        $this->nutritions = $nutritions;

        return $this;
    }

    /**
     * @param  array<mixed>  $categories
     */
    public function withCategory(array $categories = []): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param  array<mixed>  $dietaryRestriction
     */
    public function withDietaryRestriction(array $dietaryRestriction = []): self
    {
        $this->dietaryRestrictions = $dietaryRestriction;

        return $this;
    }

    /**
     * @param  array<mixed>  $images
     */
    public function withImage(array $images = []): self
    {
        $this->images = $images;

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
        $this->model->user_id = $this->user->id;

        $this->model->save();

        $this->updateImages();

        if ($this->categories) {

            /** @phpstan-ignore-next-line */
            $this->model->categories()->sync(array_values($this->categories));
        }

        if ($this->dietaryRestrictions) {

            /** @phpstan-ignore-next-line */
            $this->model->dietaryRestrictions()->sync(array_values($this->dietaryRestrictions));
        }

        if (! $this->nutritions->isEmpty()) {
            /** @phpstan-ignore-next-line */
            $this->model->nutritions()->sync($this->nutritions->keyBy('nutrition_id'));
        }

        return $this->model;
    }
}
