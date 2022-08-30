<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleDiscountDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['item_convertion_barcode', 'multiple_discount_id'];
    protected $with = ['item_convertion'];

    public function multipleDiscount()
    {
        return $this->belongsTo(MultipleDiscount::class);
    }
    public function item_convertion()
    {
        return $this->belongsTo(ItemConvertion::class, 'item_convertion_barcode', 'barcode');
    }
}
