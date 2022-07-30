<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'is_active'];
    protected $with = ['created_by', 'edit_by'];
    protected $hidden = ['created_by_id', 'edit_by_id',];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function edit_by()
    {
        return $this->belongsTo(User::class);
    }
}
