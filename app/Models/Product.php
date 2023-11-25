<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = [
        'uom_id',
        'stock_id',
        'created_by_id',
        'edit_by_id',
    ];
    protected $with = ['created_by', 'edit_by', 'uom'];

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }
    public function program()
    {
        return $this->hasOne(MultipleDiscountDetail::class);
    }
}
