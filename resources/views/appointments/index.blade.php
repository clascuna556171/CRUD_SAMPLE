@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Appointments</h1>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Book Appointment</a>
</div>

<table>
    <thead>
        <tr>
            <th>Ref #</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Dept / Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $app)
        <tr>
            <td><strong>{{ $app->reference_number }}</strong></td>
            <td>{{ $app->patient->first_name }} {{ $app->patient->last_name }}</td>
            <td>Dr. {{ $app->doctor->last_name }}</td>
            <td>
                {{ $app->schedule->department->department_name }} <br>
                <small>{{ $app->schedule->schedule_date }}</small>
            </td>
            <td>
                <span class="badge">{{ $app->status }}</span>
            </td>
            <td>
                <a href="{{ route('appointments.show', $app->appointment_id) }}" class="btn">View</a>
                <a href="{{ route('appointments.edit', $app->appointment_id) }}" class="btn">Update</a>
                <form action="{{ route('appointments.destroy', $app->appointment_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this record?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">No schedules found in the system.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection