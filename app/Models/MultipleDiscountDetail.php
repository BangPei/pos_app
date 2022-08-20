<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleDiscountDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['product_id', 'multiple_discount_id'];
    protected $with = ['product'];

    public function multipleDiscount()
    {
        return $this->belongsTo(MultipleDiscount::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getRouteKeyName()
    {
        return 'product_id';
    }
}
