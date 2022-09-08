<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['created_by_id', 'edit_by_id', 'supplier_id'];
    protected $with = ['createdBy', 'editBy', 'details', 'supplier'];

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
    public function editBy()
    {
        return $this->belongsTo(User::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function details()
    {
        return $this->belongsToMany(Product::class)->withPivot(['qty', 'tax_paid', 'total', 'invoice_price', 'pcs_price']);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
