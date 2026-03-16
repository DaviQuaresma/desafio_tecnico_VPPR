<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'value',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
        ];
    }
}
