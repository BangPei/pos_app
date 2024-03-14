<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['stock_id'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
