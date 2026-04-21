@extends('layout')

@section('content')
  <h1>Patients</h1>
  <a href="{{ route('patients.create') }}" class="btn btn-primary">Add New Patient</a>

  @if (session('success'))
    <div class="alert alert-success" style="margin-top: 15px;">
      {{ session('success') }}
    </div>
  @endif

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Contact Number</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($patients as $patient)
      <tr>
        <td>{{ $patient->patient_id }}</td>
        <td>{{ $patient->first_name }}</td>
        <td>{{ $patient->last_name }}</td>
        <td>{{ $patient->contact_number }}</td>
        <td>
          <a href="{{ route('patients.show', $patient->patient_id) }}" class="btn">View</a>
          <a href="{{ route('patients.edit', $patient->patient_id) }}" class="btn">Edit</a>
          <form action="{{ route('patients.destroy', $patient->patient_id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection