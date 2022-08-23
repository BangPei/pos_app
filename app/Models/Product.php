<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = [
        'category_id',
        'uom_id',
        'created_by_id',
        'edit_by_id',
    ];
    protected $with = ['category', 'uom', 'created_by', 'edit_by'];

    public $casts = [
        'barcode' => 'string',
    ];

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'barcode';
    }
}
