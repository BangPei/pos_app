<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['created_by', 'edit_by', 'reduce'];
    protected $hidden = ['created_by_id', 'edit_by_id', 'reduce_id'];

    public $casts = [
        'is_active' => 'boolean',
        'paid_off' => 'boolean',
        'is_default' => 'boolean',
        'reduce_option' => 'boolean',
        'show_atm' => 'boolean',
        'show_cash' => 'boolean',
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }
    public function reduce()
    {
        return $this->belongsTo(Reduce::class);
    }
    public function direcSales()
    {
        return $this->hasMany(DirectSales::class);
    }
}
