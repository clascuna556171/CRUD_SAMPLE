@extends('layout')

@section('content')
  <h1>Add New Patient</h1>
  
  @if ($errors->any())
    <div style="color: red; margin-bottom: 20px;">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('patients.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="first_name">First Name:</label>
      <input type="text" name="first_name" id="first_name" class="form-control" required maxlength="50" value="{{ old('first_name') }}">
    </div>

    <div class="form-group">
      <label for="last_name">Last Name:</label>
      <input type="text" name="last_name" id="last_name" class="form-control" required maxlength="50" value="{{ old('last_name') }}">
    </div>

    <div class="form-group">
      <label for="contact_number">Contact Number:</label>
      <input type="text" name="contact_number" id="contact_number" class="form-control" maxlength="15" value="{{ old('contact_number') }}">
    </div>

    <div class="form-group">
      <label for="medical_history">Medical History:</label>
      <textarea name="medical_history" id="medical_history" class="form-control">{{ old('medical_history') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save Patient</button>
    <a href="{{ route('patients.index') }}" class="btn">Cancel</a>
  </form>
@endsection