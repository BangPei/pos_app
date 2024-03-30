<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['platform', 'skus'];
    protected $hidden = ['daily_task_id', 'online_shop_id'];

    public function getRouteKeyName()
    {
        return 'barcode';
    }
    public function platform()
    {
        return $this->belongsTo(OnlineShop::class);
    }
    public function skus()
    {
        return $this->hasMany(ReceiptDetailSku::class);
    }
}
