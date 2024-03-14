<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'unit_name'];
    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function products()
    {
        return $this->hasMany(Product::class);
    }
}
