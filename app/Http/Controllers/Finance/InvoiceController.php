<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\SchoolSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['student','class','session'])->latest()->paginate(15);
        return view('finance.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $students = User::role('student')->get();
        $classes  = SchoolClass::all();
        $session  = SchoolSession::latest()->first();
        return view('finance.invoices.create', compact('students','classes','session'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'=>'required|exists:users,id',
            'class_id'=>'nullable|exists:school_classes,id',
            'amount'=>'required|numeric|min:0',
            'title'=>'required|string|max:255',
            'due_date'=>'nullable|date',
            'notes'=>'nullable|string',
        ]);
        $data['session_id'] = SchoolSession::latest()->value('id');
        $data['status'] = 'unpaid';
        Invoice::create($data);

        return redirect()->route('finance.invoices.index')->with('status','Invoice created');
    }

    public function edit(Invoice $invoice)
    {
        $students = User::role('student')->get();
        $classes  = SchoolClass::all();
        return view('finance.invoices.edit', compact('invoice','students','classes'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'student_id'=>'required|exists:users,id',
            'class_id'=>'nullable|exists:school_classes,id',
            'amount'=>'required|numeric|min:0',
            'title'=>'required|string|max:255',
            'status'=>'required|in:unpaid,partial,paid,overdue',
            'due_date'=>'nullable|date',
            'notes'=>'nullable|string',
        ]);
        $invoice->update($data);
        return redirect()->route('finance.invoices.index')->with('status','Invoice updated');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with('status','Invoice deleted');
    }
}
