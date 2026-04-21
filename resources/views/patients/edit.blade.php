@extends('layout')

@section('content')
  <h1>Edit Patient (ID: {{ $patient->patient_id }})</h1>
  
  @if ($errors->any())
    <div style="color: red; margin-bottom: 20px;">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('patients.update', $patient->patient_id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
      <label for="first_name">First Name:</label>
      <input type="text" name="first_name" id="first_name" class="form-control" required maxlength="50" value="{{ old('first_name', $patient->first_name) }}">
    </div>

    <div class="form-group">
      <label for="last_name">Last Name:</label>
      <input type="text" name="last_name" id="last_name" class="form-control" required maxlength="50" value="{{ old('last_name', $patient->last_name) }}">
    </div>

    <div class="form-group">
      <label for="contact_number">Contact Number:</label>
      <input type="text" name="contact_number" id="contact_number" class="form-control" maxlength="15" value="{{ old('contact_number', $patient->contact_number) }}">
    </div>

    <div class="form-group">
      <label for="medical_history">Medical History:</label>
      <textarea name="medical_history" id="medical_history" class="form-control">{{ old('medical_history', $patient->medical_history) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Patient</button>
    <a href="{{ route('patients.index') }}" class="btn">Cancel</a>
  </form>
@endsection