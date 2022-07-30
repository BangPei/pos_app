<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSalesDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['ds_id', 'product_id', 'directSales'];
    protected $with = ['directSales', 'product'];

    public function directSales()
    {
        return $this->belongsTo(DirectSales::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
