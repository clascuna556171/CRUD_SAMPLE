<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'appointment_id';
    protected $fillable = [
        'reference_number', 
        'patient_id', 
        'schedule_id', 
        'assigned_doctor_id', 
        'processed_by_id', 
        'status'
    ];

    public function invoice() {
        return $this->hasOne(Invoice::class, 'appointment_id');
    }
}
