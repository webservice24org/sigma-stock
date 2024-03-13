<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCategory extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'purchase_cat_name',];
}
