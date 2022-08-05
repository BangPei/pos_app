<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSalesDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['direct_sales_id', 'product_id'];
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
