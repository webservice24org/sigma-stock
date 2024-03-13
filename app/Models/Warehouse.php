<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'warehouse_name', 'warehouse_address'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
