<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalPrice extends Model
{
    use HasFactory;

    protected $table = 'modal_prices';
    protected $guarded = ['id'];
    protected $hidden = ['product_barcode', 'purchase_detail_id'];
    protected $with = ['product'];

    public function purchase_detail()
    {
        return $this->belongsTo(PurchaseDetail::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_barcode', 'barcode');
    }
}
