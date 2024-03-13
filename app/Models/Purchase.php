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
        'TaxNet',
        'status',
        'payment_statut',
        'notes',
    ];

    public function allSuppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_id');
    }
}
