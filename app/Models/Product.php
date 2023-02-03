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
        'created_by_id',
        'edit_by_id',
    ];
    protected $with = ['category', 'created_by', 'edit_by'];

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
    public function itemsConvertion()
    {
        return $this->hasMany(ItemConvertion::class);
    }
}
