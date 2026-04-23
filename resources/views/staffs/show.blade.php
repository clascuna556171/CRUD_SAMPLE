@extends('layout')

@section('content')
  <h1>Staff Details</h1>
  
  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
    
    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Full Name</strong>
        <p style="margin: 5px 0;">{{ $staffMember->first_name }} {{ $staffMember->last_name }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Role</strong>
        <p style="margin: 5px 0;">{{ $staffMember->role }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Department</strong>
        <p style="margin: 5px 0;">{{ $staffMember->department->department_name ?? 'Unassigned' }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Specialization</strong>
        <p style="margin: 5px 0;">{{ $staffMember->specialization ?: 'General Practice / N/A' }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">System Info</strong>
        <p style="margin: 5px 0; font-size: 0.9rem; color: #888;">
            Staff ID: #{{ $staffMember->staff_id }}<br>
            Status: <span style="color: #28a745;">● Active</span><br>
            Joined: {{ $staffMember->created_at->format('M d, Y') }}
        </p>
    </div>
  </div>

  <div class="actions">
      <a href="{{ route('staff.index') }}" class="btn">Back to Directory</a>
      <a href="{{ route('staff.edit', $staffMember->staff_id) }}" class="btn btn-primary">Edit Profile</a>
      
      <form action="{{ route('staff.destroy', $staffMember->staff_id) }}" method="POST" style="display:inline; float: right;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Remove this staff record?')">Delete</button>
      </form>
  </div>
@endsection