<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'dob',
        'nid',
        'bank_name',
        'account_holder',
        'account_number'
    ];

    public function userDetail()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
