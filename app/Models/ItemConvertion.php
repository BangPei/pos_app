<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemConvertion extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['uom'];
    protected $hidden = ['uom_id', 'product_id'];

    public $casts = [
        'barcode' => 'string',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function getRouteKeyName()
    {
        return 'barcode';
    }
}
