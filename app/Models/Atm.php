<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['created_by', 'edit_by'];
    protected $hidden = ['created_by_id', 'edit_by_id',];

    public $casts = [
        'is_active' => 'boolean',
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }
}
