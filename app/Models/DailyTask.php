<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function expeditions()
    {
        return $this->belongsToMany(Expedition::class)->withPivot(['total', 'scanned', 'cancel']);
    }
}
