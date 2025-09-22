@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Invoice #{{ $invoice->id }}</h3>

        @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
        @if($errors->any()) <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div> @endif

        <form method="POST" action="{{ route('finance.invoices.update',$invoice) }}" class="row g-3">
            @csrf @method('PUT')

            <div class="col-md-6">
                <label class="form-label">Student *</label>
                <select name="student_id" class="form-select" required>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @selected($invoice->student_id==$s->id)>{{ $s->first_name }} {{ $s->last_name }} ({{ $s->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Class</label>
                <select name="class_id" class="form-select">
                    <option value="">(none)</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" @selected($invoice->class_id==$c->id)>{{ $c->class_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Title *</label>
                <input name="title" class="form-control" value="{{ old('title',$invoice->title) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Amount *</label>
                <input type="number" step="0.01" min="0" name="amount" class="form-control" value="{{ old('amount',$invoice->amount) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    @foreach(['unpaid','partial','paid','overdue'] as $st)
                        <option value="{{ $st }}" @selected($invoice->status===$st)>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Due date</label>
                <input type="date" name="due_date" class="form-control" value="{{ optional($invoice->due_date)->format('Y-m-d') }}">
            </div>

            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes',$invoice->notes) }}</textarea>
            </div>

            <div class="col-12">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('finance.invoices.index') }}" class="btn btn-light">Back</a>
            </div>
        </form>

        {{-- إضافة دفعة سريعة --}}
        <hr class="my-4">
        <h5>Add Payment</h5>
        <form method="POST" action="{{ route('finance.invoices.payments.store',$invoice) }}" class="row g-3">
            @csrf
            <div class="col-md-3"><input type="number" step="0.01" min="0.01" name="amount" class="form-control" placeholder="Amount"></div>
            <div class="col-md-3">
                <select name="method" class="form-select">
                    @foreach(['cash','card','transfer','online'] as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"><input name="reference" class="form-control" placeholder="Reference"></div>
            <div class="col-md-12"><textarea name="notes" class="form-control" rows="2" placeholder="Notes"></textarea></div>
            <div class="col-12"><button class="btn btn-success">Add Payment</button></div>
        </form>
    </div>
@endsection
