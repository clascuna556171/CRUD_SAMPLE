@extends('layout')

@section('content')
  <h1>Patient Details</h1>
  
  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
    
    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Full Name</strong>
        <p style="margin: 5px 0;">{{ $patient->first_name }} {{ $patient->last_name }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Contact Number</strong>
        <p style="margin: 5px 0;">{{ $patient->contact_number ?: 'N/A' }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Medical History</strong>
        <div style="margin-top: 5px; padding: 10px; background: #f8fafc; border-radius: 4px; border: 1px solid #edf2f7; color: #4a5568; line-height: 1.5;">
            {{ $patient->medical_history ?: 'No medical history recorded for this patient.' }}
        </div>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">System Info</strong>
        <p style="margin: 5px 0; font-size: 0.9rem; color: #888;">
            Patient ID: #{{ $patient->patient_id }}<br>
            Registered: {{ $patient->created_at->format('M d, Y - h:i A') }}
        </p>
    </div>
  </div>

  <div class="actions">
      <a href="{{ route('patients.index') }}" class="btn">Back to List</a>
      <a href="{{ route('patients.edit', $patient->patient_id) }}" class="btn btn-primary">Edit Patient</a>
      
      <form action="{{ route('patients.destroy', $patient->patient_id) }}" method="POST" style="display:inline; float: right;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this patient record?')">Delete</button>
      </form>
  </div>
@endsection