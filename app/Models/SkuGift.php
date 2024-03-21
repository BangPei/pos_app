<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuGift extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['product_barcode'];
    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
