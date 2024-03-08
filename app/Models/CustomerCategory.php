<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'cat_name'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
