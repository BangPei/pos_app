<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSalesDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['item_convertion_barcode', 'direct_sales_id'];
    protected $with = ['product'];

    public function directSales()
    {
        return $this->belongsTo(DirectSales::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_barcode', 'barcode');
    }
}
