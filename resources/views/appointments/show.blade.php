@extends('layout')

@section('content')
  <h1>Appointment Details</h1>
  
  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
    
    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
        <div>
            <strong style="color: #666; text-transform: uppercase; font-size: 0.75rem;">Reference Number</strong>
            <h2 style="margin: 5px 0; color: #2d3748;">{{ $appointment->reference_number }}</h2>
        </div>
        <div style="text-align: right;">
            <strong style="color: #666; text-transform: uppercase; font-size: 0.75rem;">Status</strong><br>
            <span class="badge" style="
                padding: 5px 12px; 
                border-radius: 20px; 
                font-weight: bold; 
                font-size: 0.9rem;
                background: {{ $appointment->status == 'Completed' ? '#c6f6d5' : ($appointment->status == 'Cancelled' ? '#fed7d7' : '#feebc8') }};
                color: {{ $appointment->status == 'Completed' ? '#22543d' : ($appointment->status == 'Cancelled' ? '#742a2a' : '#744210') }};
            ">
                {{ $appointment->status }}
            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        {{-- Left Column: Patient & Doctor --}}
        <div>
            <div style="margin-bottom: 20px;">
                <strong style="color: #4a5568; display: block; border-left: 4px solid #4299e1; padding-left: 10px;">Patient Information</strong>
                <p style="margin: 10px 0 0 14px;">
                    <strong>Name:</strong> {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}<br>
                    <strong>Contact:</strong> {{ $appointment->patient->contact_number }}
                </p>
            </div>

            <div>
                <strong style="color: #4a5568; display: block; border-left: 4px solid #4299e1; padding-left: 10px;">Assigned Medical Staff</strong>
                <p style="margin: 10px 0 0 14px;">
                    <strong>Doctor:</strong> Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}<br>
                    <strong>Specialization:</strong> {{ $appointment->doctor->specialization }}
                </p>
            </div>
        </div>

        {{-- Right Column: Schedule & Metadata --}}
        <div>
            <div style="margin-bottom: 20px;">
                <strong style="color: #4a5568; display: block; border-left: 4px solid #4299e1; padding-left: 10px;">Schedule & Department</strong>
                <p style="margin: 10px 0 0 14px;">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->schedule->schedule_date)->format('F d, Y') }}<br>
                    <strong>Department:</strong> {{ $appointment->schedule->department->department_name }}
                </p>
            </div>

            <div style="background: #f7fafc; padding: 10px; border-radius: 5px;">
                <p style="margin: 0; font-size: 0.85rem; color: #718096;">
                    <strong>Booked On:</strong> {{ $appointment->booking_timestamp }}<br>
                    <strong>Processed By:</strong> {{ $appointment->processor->first_name ?? 'System' }} {{ $appointment->processor->last_name ?? '' }}
                </p>
            </div>
        </div>
    </div>
  </div>

  <div class="actions">
      <a href="{{ route('appointments.index') }}" class="btn">Back to Appointments</a>
      <a href="{{ route('appointments.edit', $appointment->appointment_id) }}" class="btn btn-primary">Update Status</a>
      
      @if($appointment->status == 'Completed')
        <a href="{{ route('invoices.show', $appointment->invoice->invoice_id ?? '#') }}" class="btn" style="background: #48bb78; color: white; text-decoration: none;">View Invoice</a>
      @endif

      <form action="{{ route('appointments.destroy', $appointment->appointment_id) }}" method="POST" style="display:inline; float: right;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel and delete this appointment record?')">Delete Record</button>
      </form>
  </div>
@endsection