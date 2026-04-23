@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Patients</h1>
    <a href="{{ route('patients.create') }}" class="btn btn-primary">Add New Patient</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Contact Number</th>
            <th>Medical History</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($patients as $patient)
        <tr>
            <td>{{ $patient->patient_id }}</td>
            <td><strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong></td>
            <td>{{ $patient->contact_number }}</td>
            <td>
                {{ Str::limit($patient->medical_history, 40, '...') ?? 'No history recorded' }}
            </td>
            <td>
                <a href="{{ route('patients.show', $patient->patient_id) }}" class="btn">View</a>
                <a href="{{ route('patients.edit', $patient->patient_id) }}" class="btn">Edit</a>
                
                <form action="{{ route('patients.destroy', $patient->patient_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center;">No patients found in the system.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection