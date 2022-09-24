<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['daily_task_id',];

    public function getRouteKeyName()
    {
        return 'barcode';
    }
}
