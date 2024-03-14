<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'supplier_id',
        'warehouse_id',
        'purchase_category_id',
        'unit_id',
        'date',
        'tax_rate',
        'payment_statut',
        'notes',
        'discount',
        'shipping_cost',
        'purchase_qty',
        'grand_total',
        'paid_amount',
        'due_amount',
    ];

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_id');
    }
    public function warehouse()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_id');
    }
    public function purchaseCategory()
    {
        return $this->belongsToMany(PurchaseCategory::class, 'purchase_category_id');
    }
    public function unit()
    {
        return $this->belongsToMany(ProductUnit::class, 'unit_id');
    }
}
