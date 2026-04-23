@extends('layout')

@section('content')
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1>Edit Patient Profile</h1>
      <span style="color: #718096;">ID: #{{ $patient->patient_id }}</span>
  </div>
  
  {{-- Standardized Error Block --}}
  @if ($errors->any())
    <div class="alert btn-danger" style="margin-bottom: 20px; border: none; border-radius: 4px;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <form action="{{ route('patients.update', $patient->patient_id) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          <div class="form-group">
            <label for="first_name" style="font-weight: bold;">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required maxlength="50" value="{{ old('first_name', $patient->first_name) }}">
          </div>

          <div class="form-group">
            <label for="last_name" style="font-weight: bold;">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required maxlength="50" value="{{ old('last_name', $patient->last_name) }}">
          </div>
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label for="contact_number" style="font-weight: bold;">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number" class="form-control" maxlength="15" value="{{ old('contact_number', $patient->contact_number) }}">
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label for="medical_history" style="font-weight: bold;">Medical History</label>
        <textarea name="medical_history" id="medical_history" class="form-control" rows="5" placeholder="Enter patient allergies, previous surgeries, or chronic conditions...">{{ old('medical_history', $patient->medical_history) }}</textarea>
      </div>

      <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Update Patient Record</button>
        <a href="{{ route('patients.index') }}" class="btn">Cancel</a>
      </div>
    </form>
  </div>
@endsection