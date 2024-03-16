<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'customer_id',
        'warehouse_id',
        'tax_percentage',
        'discount',
        'shipping_amount',
        'total_amount',
        'product_id',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function products()
    {
        return $this->belongsTo(Warehouse::class, 'product_id');
    }
}
