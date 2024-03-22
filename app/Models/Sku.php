<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['details', 'gifts'];

    public function details()
    {
        return $this->hasMany(SkuDetail::class);
    }
    public function gifts()
    {
        return $this->hasMany(SkuGift::class);
    }
}
