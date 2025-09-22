@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Add Staff</h3>

        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('staff.store') }}" class="row g-3">
            @csrf
            <div class="col-md-3"><label class="form-label">First name *</label><input name="first_name" class="form-control" required value="{{ old('first_name') }}"></div>
            <div class="col-md-3"><label class="form-label">Last name *</label><input name="last_name" class="form-control" required value="{{ old('last_name') }}"></div>
            <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
            <div class="col-md-3"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone') }}"></div>

            <div class="col-md-4"><label class="form-label">Job title *</label><input name="job_title" class="form-control" required value="{{ old('job_title','Staff') }}"></div>
            <div class="col-md-4">
                <label class="form-label">Salary type *</label>
                <select name="salary_type" class="form-select" required>
                    <option value="fixed" @selected(old('salary_type')==='fixed')>fixed</option>
                    <option value="hourly" @selected(old('salary_type')==='hourly')>hourly</option>
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Base salary *</label><input type="number" step="0.01" min="0" name="base_salary" class="form-control" required value="{{ old('base_salary',0) }}"></div>

            <div class="col-md-4"><label class="form-label">Join date</label><input type="date" name="join_date" class="form-control" value="{{ old('join_date') }}"></div>
            <div class="col-md-4">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    <option value="active" @selected(old('status')==='active')>active</option>
                    <option value="inactive" @selected(old('status')==='inactive')>inactive</option>
                </select>
            </div>

            <div class="col-12">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('staff.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
@endsection
