<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineShop extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public $casts = [
        'is_active' => 'boolean',
    ];
}
