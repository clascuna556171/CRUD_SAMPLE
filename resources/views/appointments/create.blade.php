@extends('layout')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Book New Appointment</h1>
        <a href="{{ route('appointments.index') }}" class="btn">Cancel</a>
    </div>

    {{-- Validation Errors --}}
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
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            {{-- Patient Selection --}}
            <div class="form-group">
                <label for="patient_id" style="font-weight: bold;">Select Patient:</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    <option value="" disabled selected>-- Search Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->patient_id }}" {{ old('patient_id') == $patient->patient_id ? 'selected' : '' }}>
                            {{ $patient->first_name }} {{ $patient->last_name }} (ID: {{ $patient->patient_id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                {{-- Doctor Selection --}}
                <div class="form-group">
                    <label for="assigned_doctor_id" style="font-weight: bold;">Assign Doctor:</label>
                    <select name="assigned_doctor_id" id="assigned_doctor_id" class="form-control" required>
                        <option value="" disabled selected>-- Select Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->staff_id }}" {{ old('assigned_doctor_id') == $doctor->staff_id ? 'selected' : '' }}>
                                Dr. {{ $doctor->first_name }} {{ $doctor->last_name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Schedule Selection --}}
                <div class="form-group">
                    <label for="schedule_id" style="font-weight: bold;">Select Schedule Date:</label>
                    <select name="schedule_id" id="schedule_id" class="form-control" required>
                        <option value="" disabled selected>-- Select Available Date --</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->schedule_id }}" {{ old('schedule_id') == $schedule->schedule_id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('M d, Y') }} - {{ $schedule->department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Info Box --}}
            <div style="margin-top: 25px; background: #eef2f7; padding: 15px; border-radius: 6px; color: #4a5568; font-size: 0.9rem;">
                <p style="margin: 0;"><strong>Note:</strong> A unique Reference Number will be automatically generated upon submission. The appointment status will be set to <strong>Pending</strong> by default.</p>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-weight: bold;">Confirm Booking</button>
            </div>
        </form>
    </div>
@endsection