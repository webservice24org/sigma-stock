<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'type_barcode',
        'name',
        'making_cost',
        'general_price',
        'category_id',
        'unit_id',
        'discount',
        'tax_rate',
        'image',
        'note',
        'stock_alert',
    ];

    public static function rules()
    {
        return [
            'code' => 'required|string|max:192',
            'type_barcode' => 'required|string|max:192',
            'name' => 'required|string|max:192',
            'making_cost' => 'required|numeric',
            'general_price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'nullable|exists:product_units,id',
            'discount' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'image' => 'nullable|image',
            'note' => 'nullable|string',
            'stock_alert' => 'nullable|numeric',
        ];
    }

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
}
