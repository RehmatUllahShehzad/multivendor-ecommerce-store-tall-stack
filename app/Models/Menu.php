<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    private static ?Collection $loadedCollection = null;

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Menu $menu) {
            if ($menu->items->isEmpty()) {
                return;
            }

            foreach ($menu->items as $menuItem) {
                $menuItem->delete();
            }
        });
    }

    public function scopeByName(Builder $builder, string $name): Builder
    {
        return $builder->where('name', $name);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id')->defaultOrder();
    }

    public function topLevelItems(): HasMany
    {
        return $this->items()->root();
    }

    public static function getMenuByName($name)
    {
        if(is_null(static::$loadedCollection)) {
            static::$loadedCollection = MenuItem::query()
                ->addSelect(['menu_name' => Menu::select('name')->whereId(DB::raw('`menu_items`.`menu_id`'))])
                ->with('children.media')
                ->root()
                ->defaultOrder()
                ->get()
                ->groupBy('menu_name');
        }

        return static::$loadedCollection->get($name);
    }
}
