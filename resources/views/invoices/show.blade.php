@extends('layout')

@section('content')
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1>Invoice Details</h1>
      <button onclick="window.print()" class="btn">Print Record</button>
  </div>
  
  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
    
    {{-- Status Banner --}}
    <div style="margin-bottom: 20px; padding: 10px; border-radius: 4px; background: {{ $invoice->payment_status == 'Paid' ? '#d4edda' : '#fff3cd' }}; color: {{ $invoice->payment_status == 'Paid' ? '#155724' : '#856404' }};">
        <strong>Status:</strong> {{ strtoupper($invoice->payment_status) }}
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Invoice Number</strong>
        <p style="margin: 5px 0;">#{{ $invoice->invoice_id }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Patient Name</strong>
        <p style="margin: 5px 0;">{{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Appointment Reference</strong>
        <p style="margin: 5px 0;">{{ $invoice->appointment->reference_number }} ({{ $invoice->appointment->schedule->department->department_name }})</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Amount Due</strong>
        <p style="margin: 5px 0; font-size: 1.2rem; font-weight: bold;">${{ number_format($invoice->total_amount, 2) }}</p>
    </div>

    <div class="form-group">
        <strong style="color: #666; text-transform: uppercase; font-size: 0.8rem;">Dates</strong>
        <p style="margin: 5px 0; font-size: 0.9rem; color: #888;">
            Issued on: {{ \Carbon\Carbon::parse($invoice->issued_date)->format('M d, Y') }}<br>
            System Log: {{ $invoice->created_at->format('M d, Y - h:i A') }}
        </p>
    </div>
  </div>

  <div class="actions">
      <a href="{{ route('invoices.index') }}" class="btn">Back to List</a>
      
      @if($invoice->payment_status !== 'Paid')
          <a href="{{ route('invoices.edit', $invoice->invoice_id) }}" class="btn btn-primary">Process Payment</a>
      @endif

      <form action="{{ route('invoices.destroy', $invoice->invoice_id) }}" method="POST" style="display:inline; float: right;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this invoice record?')">Delete</button>
      </form>
  </div>
@endsection