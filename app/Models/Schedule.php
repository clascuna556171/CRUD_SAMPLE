<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['department_id', 'schedule_date', 'max_capacity', 'current_booked'];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
