<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    public function getMetaValue($key, $default = null): mixed
    {
        return cast_meta_object($this, $key, $default);
    }
}
