@extends('layout')

@section('content')
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1>Edit Appointment</h1>
      <span style="color: #718096;">Ref: {{ $appointment->reference_number }}</span>
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
    <form action="{{ route('appointments.update', $appointment->appointment_id) }}" method="POST">
      @csrf
      @method('PUT')
      
      {{-- Patient Selection (Likely read-only in most medical systems, but included for editing) --}}
      <div class="form-group">
        <label for="patient_id" style="font-weight: bold;">Patient</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->patient_id }}" 
                    {{ old('patient_id', $appointment->patient_id) == $patient->patient_id ? 'selected' : '' }}>
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </option>
            @endforeach
        </select>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
          {{-- Doctor Selection --}}
          <div class="form-group">
            <label for="assigned_doctor_id" style="font-weight: bold;">Assigned Doctor</label>
            <select name="assigned_doctor_id" id="assigned_doctor_id" class="form-control" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->staff_id }}" 
                        {{ old('assigned_doctor_id', $appointment->assigned_doctor_id) == $doctor->staff_id ? 'selected' : '' }}>
                        Dr. {{ $doctor->last_name }} ({{ $doctor->specialization }})
                    </option>
                @endforeach
            </select>
          </div>

          {{-- Schedule Selection --}}
          <div class="form-group">
            <label for="schedule_id" style="font-weight: bold;">Schedule / Date</label>
            <select name="schedule_id" id="schedule_id" class="form-control" required>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->schedule_id }}" 
                        {{ old('schedule_id', $appointment->schedule_id) == $schedule->schedule_id ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('M d, Y') }} - {{ $schedule->department->department_name }}
                    </option>
                @endforeach
            </select>
          </div>
      </div>

      {{-- Status Update --}}
      <div class="form-group" style="margin-top: 15px;">
          <label for="status" style="font-weight: bold;">Appointment Status</label>
          <select name="status" id="status" class="form-control" required>
              <option value="Pending" {{ old('status', $appointment->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
              <option value="Confirmed" {{ old('status', $appointment->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
              <option value="Completed" {{ old('status', $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
              <option value="Cancelled" {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
      </div>

      <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Update Appointment</button>
        <a href="{{ route('appointments.index') }}" class="btn">Cancel</a>
      </div>
    </form>
  </div>
@endsection