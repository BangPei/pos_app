<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStock extends Model
{
    use HasFactory;

    protected $table = 'stock_histories';
    protected $guarded = ['id'];
    protected $hidden = ['stock_id'];
    protected $with = ['stock'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
