<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptDetailSku extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['gift', 'manuals'];
    protected $hidden = [
        'receipt_id',
        'product_barcode',
    ];

    public $casts = [
        'valid' => 'boolean',
    ];

    public function gift()
    {
        return $this->belongsTo(Product::class, 'product_barcode', 'barcode');
    }
    public function manuals()
    {
        return $this->hasMany(ReceiptDetailProduct::class);
    }
}
