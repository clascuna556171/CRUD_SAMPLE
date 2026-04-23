<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_doctor_id', 'staff_id');
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'processed_by_id', 'staff_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'appointment_id', 'appointment_id');
    }
}