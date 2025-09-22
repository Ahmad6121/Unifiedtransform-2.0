<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\SchoolSession;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('session')->paginate(20);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $session = SchoolSession::latest()->first();
        return view('staff.create', compact('session'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'=>'required|string|max:80',
            'last_name'=>'required|string|max:80',
            'email'=>'nullable|email|unique:staff,email',
            'phone'=>'nullable|string|max:20',
            'job_title'=>'required|string|max:120',
            'salary_type'=>'required|in:fixed,hourly',
            'base_salary'=>'required|numeric|min:0',
            'join_date'=>'nullable|date',
            'status'=>'required|in:active,inactive',
        ]);
        $data['session_id'] = SchoolSession::latest()->value('id');
        Staff::create($data);

        return redirect()->route('staff.index')->with('status','Staff member added');
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'job_title'=>'required|string|max:120',
            'salary_type'=>'required|in:fixed,hourly',
            'base_salary'=>'required|numeric|min:0',
            'join_date'=>'nullable|date',
            'status'=>'required|in:active,inactive',
        ]);
        $staff->update($data);
        return redirect()->route('staff.index')->with('status','Staff updated');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return back()->with('status','Staff deleted');
    }
}
