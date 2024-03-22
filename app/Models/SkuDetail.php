<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['product_barcode'];
    protected $with = ['product'];

    public $casts = [
        'is_variant' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_barcode', 'barcode');
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
