@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Department Schedules</h1>
    <a href="{{ route('schedules.create') }}" class="btn btn-primary">Create New Schedule</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Department</th>
            <th>Date</th>
            <th>Capacity</th>
            <th>Booked</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($schedules as $schedule)
        <tr>
            <td>{{ $schedule->schedule_id }}</td>
            <td><strong>{{ $schedule->department->department_name }}</strong></td>
            <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('M d, Y') }}</td>
            <td>{{ $schedule->max_capacity }}</td>
            <td>{{ $schedule->current_booked }}</td>
            <td>
                @php
                    $remaining = $schedule->max_capacity - $schedule->current_booked;
                @endphp
                @if($remaining <= 0)
                    <span style="color: red; font-weight: bold;">Full</span>
                @else
                    <span style="color: green;">{{ $remaining }} Slots Left</span>
                @endif
            </td>
            <td>
                <a href="{{ route('schedules.show', $schedule->schedule_id) }}" class="btn">View</a>
                <a href="{{ route('schedules.edit', $schedule->schedule_id) }}" class="btn">Edit</a>
                <form action="{{ route('schedules.destroy', $schedule->schedule_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this schedule?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center;">No schedules available.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection