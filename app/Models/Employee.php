<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'hrm_department_id',
        'salary_amount',
        'joining_date',
        'status',
        'note',
        'regine_date'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(HrmDepartment::class, 'hrm_department_id');
    }

}
