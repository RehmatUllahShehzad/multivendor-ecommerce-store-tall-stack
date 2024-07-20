<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPackagesItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'meta' => 'array',
        'status' => OrderStatus::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderPackage(): BelongsTo
    {
        return $this->belongsTo(OrderPackage::class);
    }

    public function total()
    {
        return $this->quantity * $this->price;
    }
}
