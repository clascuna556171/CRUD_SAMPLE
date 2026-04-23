<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'staff_id';
    protected $fillable = ['first_name', 'last_name', 'role', 'specialization', 'department_id'];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
