@extends('layout')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Add New Medical Staff</h1>
        <a href="{{ route('staff.index') }}" class="btn">Cancel</a>
    </div>

    {{-- Error Handling --}}
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
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                {{-- First Name --}}
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
                </div>

                {{-- Last Name --}}
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
                {{-- Role Selection --}}
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option value="Doctor" {{ old('role') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="Nurse" {{ old('role') == 'Nurse' ? 'selected' : '' }}>Nurse</option>
                        <option value="Admissions Clerk" {{ old('role') == 'Admissions Clerk' ? 'selected' : '' }}>Admissions Clerk</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                {{-- Department Dropdown --}}
                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="form-control">
                        <option value="">-- No Department --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->department_id }}" {{ old('department_id') == $dept->department_id ? 'selected' : '' }}>
                                {{ $dept->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Specialization --}}
            <div class="form-group" style="margin-top: 15px;">
                <label for="specialization">Specialization (Optional)</label>
                <input type="text" name="specialization" id="specialization" class="form-control" placeholder="e.g. Pediatrician, Surgery" value="{{ old('specialization') }}">
                <small style="color: #888;">Only applicable for Doctors or specialized Nurses.</small>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; pt-20px; padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Save Staff Record</button>
            </div>
        </form>
    </div>
@endsection