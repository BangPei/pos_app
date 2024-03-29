<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchase';
    protected $guarded = ['id'];
    protected $hidden = ['supplier_id'];
    protected $with = ['supplier'];

    public $casts = [
        'is_distributor' => 'boolean',
        'tax_in_price' => 'boolean',
        'status' => 'boolean',
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
