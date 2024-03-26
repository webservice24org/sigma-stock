<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'making_cost',
        'general_price',
        'category_id',
        'unit_id',
        'discount',
        'tax_rate',
        'image',
        'stock_alert',
        'product_desc',
    ];

    

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category of the product.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }
}
