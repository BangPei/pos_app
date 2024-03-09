<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_detail';
    protected $guarded = ['id'];
    protected $hidden = ['product_barcode', 'stock_id', 'uom_id', 'purchase_id'];
    protected $with = ['product', 'stock', 'uom'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }
    public function detail_modals()
    {
        return $this->hasMany(ModalPrice::class);
    }
}
