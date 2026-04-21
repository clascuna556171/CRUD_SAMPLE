<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = 'patient_id';
    
    protected $fillable = [
        'first_name',
        'last_name',
        'contact_number',
        'medical_history',
    ];
}
