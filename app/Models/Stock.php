<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['created_by', 'edit_by', 'category'];
    protected $hidden = ['created_by_id', 'edit_by_id', 'category_id'];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function histories()
    {
        return $this->hasMany(StockHistory::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
