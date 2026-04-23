@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Hospital Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn btn-primary">Add New Department</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Department Name</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($departments as $dept)
        <tr>
            <td>{{ $dept->department_id }}</td>
            <td><strong>{{ $dept->department_name }}</strong></td>
            <td>{{ Str::limit($dept->description, 60) ?? 'No description' }}</td>
            <td>{{ $dept->created_at->format('M d, Y') }}</td>
            <td>
                <a href="{{ route('departments.show', $dept->department_id) }}" class="btn">View</a>
                <a href="{{ route('departments.edit', $dept->department_id) }}" class="btn">Edit</a>
                <form action="{{ route('departments.destroy', $dept->department_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Deleting this will affect assigned schedules. Continue?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center;">No departments found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection