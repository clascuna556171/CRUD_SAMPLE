@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Medical Staff Directory</h1>
    <a href="{{ route('staff.create') }}" class="btn btn-primary">+ Add Staff</a>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staff as $s)
        <tr>
            <td>{{ $s->first_name }} {{ $s->last_name }}</td>
            <td>{{ $s->role }}</td>
            <td>{{ $s->department->department_name ?? 'N/A' }}</td>
            <td>
                <a href="{{ route('staff.show', $s->staff_id) }}" class="btn">View</a>
                 <a href="{{ route('staff.edit', $s->staff_id) }}" class="btn">Edit</a>
                <form action="{{ route('staff.destroy', $s->staff_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this record?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection