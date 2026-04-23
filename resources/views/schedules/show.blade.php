@extends('layout')

@section('content')
  <h1>Schedule Details</h1>
  
  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
    
    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Department</strong>
        <p style="margin: 5px 0;">{{ $schedule->department->department_name }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Schedule Date</strong>
        <p style="margin: 5px 0;">{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('l, F d, Y') }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Capacity Status</strong>
        <p style="margin: 5px 0;">
            {{ $schedule->current_booked }} / {{ $schedule->max_capacity }} Slots Filled 
            (@if($schedule->current_booked >= $schedule->max_capacity)
                <span style="color: #dc3545; font-weight: bold;">Fully Booked</span>
            @else
                <span style="color: #28a745; font-weight: bold;">Available</span>
            @endif)
        </p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">System Records</strong>
        <p style="margin: 5px 0; font-size: 0.9rem; color: #888;">
            ID: #SCH-{{ $schedule->schedule_id }}<br>
            Created on: {{ $schedule->created_at->format('M d, Y') }}<br>
            Last Updated: {{ $schedule->updated_at->diffForHumans() }}
        </p>
    </div>
  </div>

  <div class="actions">
      <a href="{{ route('schedules.index') }}" class="btn">Back to List</a>
      
      <a href="{{ route('appointments.index', ['schedule_id' => $schedule->schedule_id]) }}" class="btn btn-primary">View Appointments</a>

      <form action="{{ route('schedules.destroy', $schedule->schedule_id) }}" method="POST" style="display:inline; float: right;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Deleting this schedule will affect existing appointments. Proceed?')">Delete</button>
      </form>
  </div>
@endsection