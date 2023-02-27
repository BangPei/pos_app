<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['user', 'product', 'stock'];
    protected $hidden = ['user_id', 'product_id', 'stock_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
