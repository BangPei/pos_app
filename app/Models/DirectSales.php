<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSales extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['created_by_id', 'edit_by_id', 'payment_type_id'];
    protected $with = ['createdBy', 'editBy', 'details', 'paymentType', 'bank'];

    public $casts = [
        'code' => 'string',
        'is_cash' => 'boolean',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
    public function editBy()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
    public function bank()
    {
        return $this->belongsTo(Atm::class, 'bank_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(DirectSalesDetail::class);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
