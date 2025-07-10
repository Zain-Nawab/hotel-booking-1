@extends('admin.layout')
@section('title', 'Reports')
@section('content')
<div class="content container-fluid py-4">
    <h1 class="mb-4 fw-bold text-dark">
        <i class="bi bi-file-earmark-text me-2"></i>Reports
    </h1>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Generate Report</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.main') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="report_type" class="form-label">Select Report Type</label>
                    <select name="report_type" id="report_type" class="form-select" required>
                        <option value="">-- Select Report Type --</option>
                        <option value="daily">Daily Report</option>
                        <option value="weekly">Weekly Report</option>
                        <option value="monthly">Monthly Report</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
        </div>
    </div>
</div>
@endsection