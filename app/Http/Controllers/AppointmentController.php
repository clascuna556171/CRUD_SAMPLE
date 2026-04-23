<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Schedule;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'schedule.department'])->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Staff::where('role', 'Doctor')->get();
        $schedules = Schedule::with('department')->get();
        return view('appointments.create', compact('patients', 'doctors', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'assigned_doctor_id' => 'required|exists:staff,staff_id',
        ]);

        // Generate a unique reference number
        $ref = 'APP-' . strtoupper(uniqid());

        Appointment::create([
            'reference_number' => $ref,
            'patient_id' => $request->patient_id,
            'schedule_id' => $request->schedule_id,
            'assigned_doctor_id' => $request->assigned_doctor_id,
            'status' => 'Pending'
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::all();
        $doctors = Staff::where('role', 'Doctor')->get();
        $schedules = Schedule::with('department')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'schedules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'assigned_doctor_id' => 'required|exists:staff,staff_id',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully!');
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment removed.');
    }
}