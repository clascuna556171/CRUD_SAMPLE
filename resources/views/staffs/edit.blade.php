@extends('layout')

@section('content')
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1>Edit Staff Profile</h1>
      <span style="color: #718096;">ID: #{{ $staffMember->staff_id }}</span>
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
    <form action="{{ route('staff.update', $staffMember->staff_id) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          {{-- First Name --}}
          <div class="form-group">
            <label for="first_name" style="font-weight: bold;">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required maxlength="50" value="{{ old('first_name', $staffMember->first_name) }}">
          </div>

          {{-- Last Name --}}
          <div class="form-group">
            <label for="last_name" style="font-weight: bold;">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required maxlength="50" value="{{ old('last_name', $staffMember->last_name) }}">
          </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
          {{-- Role --}}
          <div class="form-group">
            <label for="role" style="font-weight: bold;">Role</label>
            <select name="role" id="role" class="form-control" required>
                @foreach(['Doctor', 'Nurse', 'Admissions Clerk', 'Admin'] as $role)
                    <option value="{{ $role }}" {{ old('role', $staffMember->role) == $role ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
          </div>

          {{-- Department --}}
          <div class="form-group">
            <label for="department_id" style="font-weight: bold;">Department</label>
            <select name="department_id" id="department_id" class="form-control">
                <option value="">-- No Department --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->department_id }}" {{ old('department_id', $staffMember->department_id) == $dept->department_id ? 'selected' : '' }}>
                        {{ $dept->department_name }}
                    </option>
                @endforeach
            </select>
          </div>
      </div>

      {{-- Specialization --}}
      <div class="form-group" style="margin-top: 15px;">
        <label for="specialization" style="font-weight: bold;">Specialization (Optional)</label>
        <input type="text" name="specialization" id="specialization" class="form-control" maxlength="100" value="{{ old('specialization', $staffMember->specialization) }}">
      </div>

      <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Update Profile</button>
        <a href="{{ route('staff.index') }}" class="btn">Cancel</a>
      </div>
    </form>
  </div>
@endsection