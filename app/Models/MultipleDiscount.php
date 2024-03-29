<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleDiscount extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['created_by_id', 'edit_by_id'];
    protected $with = ['createdBy', 'editBy', 'details'];

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
    public function editBy()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(MultipleDiscountDetail::class);
    }
}
