<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')->get();
        return view('staffs.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('staffs.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'role' => 'required|in:Doctor,Nurse,Admissions Clerk,Admin',
            'department_id' => 'nullable|exists:departments,department_id',
            'specialization' => 'nullable|string|max:100',
        ]);

        Staff::create($request->all());

        // Use 'staff.index' to match your Route::resource('staff', ...)
        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }

    public function show($id)
    {
        $staffMember = Staff::with('department')->findOrFail($id);
        return view('staffs.show', compact('staffMember'));
    }

    public function edit($id)
    {
        $staffMember = Staff::findOrFail($id);
        $departments = Department::all();
        
        return view('staffs.edit', compact('staffMember', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'role' => 'required|in:Doctor,Nurse,Admissions Clerk,Admin',
            'department_id' => 'nullable|exists:departments,department_id',
            'specialization' => 'nullable|string|max:100',
        ]);

        $staffMember = Staff::findOrFail($id);
        $staffMember->update($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff profile updated successfully.');
    }

    public function destroy($id)
    {
        $staffMember = Staff::findOrFail($id);
        $staffMember->delete();
        
        return redirect()->route('staff.index')->with('success', 'Staff record deleted.');
    }
}