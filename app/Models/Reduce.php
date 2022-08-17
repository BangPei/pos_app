<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reduce extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $with = ['created_by', 'edit_by'];
    protected $hidden = ['created_by_id', 'edit_by_id',];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
