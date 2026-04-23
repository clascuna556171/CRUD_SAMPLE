@extends('layout')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Create New Schedule</h1>
        <a href="{{ route('schedules.index') }}" class="btn">Cancel</a>
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
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf

            {{-- Department Selection --}}
            <div class="form-group">
                <label for="department_id" style="font-weight: bold;">Assign to Department:</label>
                <select name="department_id" id="department_id" class="form-control" required>
                    <option value="" disabled selected>-- Select a Department --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->department_id }}" {{ old('department_id') == $dept->department_id ? 'selected' : '' }}>
                            {{ $dept->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
                {{-- Schedule Date --}}
                <div class="form-group">
                    <label for="schedule_date" style="font-weight: bold;">Date:</label>
                    <input type="date" 
                           name="schedule_date" 
                           id="schedule_date" 
                           class="form-control" 
                           value="{{ old('schedule_date', date('Y-m-d')) }}" 
                           required>
                </div>

                {{-- Max Capacity --}}
                <div class="form-group">
                    <label for="max_capacity" style="font-weight: bold;">Max Capacity (Slots):</label>
                    <input type="number" 
                           name="max_capacity" 
                           id="max_capacity" 
                           class="form-control" 
                           min="1" 
                           placeholder="e.g. 15" 
                           value="{{ old('max_capacity', 10) }}" 
                           required>
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Save Schedule</button>
            </div>
        </form>
    </div>
@endsection