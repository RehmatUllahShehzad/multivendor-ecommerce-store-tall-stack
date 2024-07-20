<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaravelJsonColumn\Traits\JsonColumn;

class Form extends Model
{
    use HasFactory, JsonColumn;

    protected $casts = [
        'extra_data' => 'array',
        'created_at' => 'date',
    ];

    protected $guarded = [];

    const TYPE_CONTACT_US = 'contact_us';

    const TYPE_SELL_NOW = 'sell_now';

    public function getType()
    {
        return Str::of($this->type)->replace('_', ' ')->title();
    }
}
