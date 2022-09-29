<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['expedition', 'receipts'];
    protected $hidden = ['expedition_id',];

    public $casts = [
        'status' => 'boolean',
    ];

    public function expedition()
    {
        return $this->belongsTo(Expedition::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
