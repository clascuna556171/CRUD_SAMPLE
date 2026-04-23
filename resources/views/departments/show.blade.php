@extends('layout')

@section('content')
  <h1>Department Details</h1>
  
  <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
    <div style="margin-bottom: 15px;">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Department Name</strong>
        <h2 style="margin: 5px 0;">{{ $department->department_name }}</h2>
    </div>

    <div style="margin-bottom: 15px;">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Internal ID</strong>
        <p style="margin: 5px 0;">#{{ $department->department_id }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Description</strong>
        <p style="margin: 5px 0; line-height: 1.6;">
            {{ $department->description ?: 'No description provided for this department.' }}
        </p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">System Records</strong>
        <p style="margin: 5px 0; font-size: 0.9rem; color: #888;">
            Registered on: {{ $department->created_at->format('M d, Y - h:i A') }}<br>
            Last Updated: {{ $department->updated_at->diffForHumans() }}
        </p>
    </div>
  </div>

  <div class="actions">
      <a href="{{ route('departments.index') }}" class="btn">Back to List</a>
      <a href="{{ route('departments.edit', $department->department_id) }}" class="btn btn-primary">Edit Department</a>
      
      <form action="{{ route('departments.destroy', $department->department_id) }}" method="POST" style="display:inline; float: right;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this entire department?')">Delete</button>
      </form>
  </div>
@endsection