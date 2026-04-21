@extends('layout')

@section('content')
  <h1>Patient Details: {{ $patient->first_name }} {{ $patient->last_name }}</h1>
  
  <div style="margin-bottom: 20px;">
    <strong>Patient ID:</strong> {{ $patient->patient_id }}<br>
    <strong>First Name:</strong> {{ $patient->first_name }}<br>
    <strong>Last Name:</strong> {{ $patient->last_name }}<br>
    <strong>Contact Number:</strong> {{ $patient->contact_number ?: 'N/A' }}<br>
    <strong>Medical History:</strong>
    <p>{{ $patient->medical_history ?: 'No medical history provided.' }}</p>
    <strong>Created At:</strong> {{ $patient->created_at }}<br>
  </div>

  <a href="{{ route('patients.index') }}" class="btn">Back to List</a>
  <a href="{{ route('patients.edit', $patient->patient_id) }}" class="btn btn-primary">Edit</a>
@endsection