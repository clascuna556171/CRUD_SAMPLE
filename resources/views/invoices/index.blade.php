@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Billing & Invoices</h1>
</div>

<table>
    <thead>
        <tr>
            <th>Invoice ID</th>
            <th>Ref #</th>
            <th>Patient</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Issued Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($invoices as $invoice)
        <tr>
            <td>#{{ $invoice->invoice_id }}</td>
            <td>{{ $invoice->appointment->reference_number }}</td>
            <td>{{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}</td>
            <td><strong>${{ number_format($invoice->total_amount, 2) }}</strong></td>
            <td>
                <span class="badge status-{{ strtolower(str_replace(' ', '-', $invoice->payment_status)) }}">
                    {{ $invoice->payment_status }}
                </span>
            </td>
            <td>{{ \Carbon\Carbon::parse($invoice->issued_date)->format('M d, Y') }}</td>
            <td>
                <a href="{{ route('invoices.show', $invoice->invoice_id) }}" class="btn">View PDF</a>
                <form action="{{ route('invoices.destroy', $invoice->invoice_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this invoice?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center;">No billing records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection