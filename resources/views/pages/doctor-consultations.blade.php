@extends('layouts.contentLayoutMaster')
@section('title','Doctor Consultations')

@section('content')
<style>
  .queue-page{max-width:1280px;margin:0 auto}.queue-header{background:linear-gradient(135deg,#356fc5,#6799df);color:#fff;border-radius:14px;padding:24px 26px;margin-bottom:18px;box-shadow:0 8px 24px rgba(45,91,155,.16)}.queue-header h3{color:#fff;margin:0 0 4px;font-weight:700}.queue-card{background:#fff;border:1px solid #e3e9f2;border-radius:14px;box-shadow:0 8px 28px rgba(35,58,92,.07);overflow:hidden}.queue-tools{padding:18px 20px;border-bottom:1px solid #edf1f6;display:flex;justify-content:space-between;align-items:center;gap:16px}.search-form{display:flex;gap:8px;width:390px;max-width:100%}.search-form .form-control{border:1px solid #dce4ef;border-radius:8px}.queue-table{margin:0}.queue-table thead th{background:#f5f8fc;color:#536b89;border:0;font-size:11px;text-transform:uppercase;letter-spacing:.35px;padding:13px}.queue-table td{padding:14px 13px;border-color:#edf1f5;vertical-align:middle;color:#52657d}.patient-name{font-weight:700;color:#203f69}.patient-meta{font-size:11px;color:#8794a5}.purpose-badge{display:inline-block;background:#edf4ff;color:#356ab2;border-radius:20px;padding:5px 9px;font-size:11px;margin:2px}.waiting-badge{background:#fff5dc;color:#9a6a00;border-radius:20px;padding:6px 10px;font-size:11px;font-weight:700}.queue-empty{text-align:center;padding:70px 20px;color:#8390a3}.queue-empty i{font-size:42px;color:#c7d2e0}.queue-footer{padding:14px 20px;border-top:1px solid #edf1f5}.btn-open{border-radius:8px;background:#326bc3;border-color:#326bc3;white-space:nowrap}@media(max-width:767px){.queue-tools{align-items:stretch;flex-direction:column}.search-form{width:100%}}
</style>
<div class="queue-page">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  <div class="queue-header"><h3>Doctor Consultation Queue</h3>
    <div>New nurse intake records awaiting clinical consultation.</div>
  </div>
  <div class="queue-card">
    <div class="queue-tools">
      <div>
        <strong>{{ $consultations->total() }}</strong> 
        patient{{ $consultations->total() === 1 ? '' : 's' }} waiting
      </div>
      <form method="GET" action="{{ route('medical.doctor-consultations') }}" class="search-form">
        <input class="form-control" name="search" value="{{ $search }}" placeholder="Search patient name or ID">
        <button class="btn btn-primary">Search</button>
        @if($search)
        <a href="{{ route('medical.doctor-consultations') }}" class="btn btn-light">Clear</a>
        @endif
      </form>
    </div>
    @if($consultations->count())
    <div class="table-responsive">
      <table class="table queue-table zero-configuration">
      <thead>
        <tr>
          <th>Patient</th>
          <th>Date & Time</th>
          <th>Purpose</th>
          <th>Chief Complaint / Findings</th>
          <th>Vitals</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach($consultations as $record)
      @php $purposes = json_decode($record->purpose, true) ?: []; $fullName = trim($record->patient_first_name.' '.$record->patient_middle_name.' '.$record->patient_last_name); @endphp
      <tr>
        <td>
        <div class="patient-name">{{ $fullName ?: 'Patient '.$record->patientId }}</div>
        <div class="patient-meta">{{ $record->patientId }} · {{ $record->role }}</div>
      </td>
      <td>{{ date('M d, Y', strtotime($record->date)) }}
        <div class="patient-meta">{{ $record->time ? date('h:i A', strtotime($record->time)) : '—' }}</div>
      </td>
      <td>@foreach($purposes as $purpose)<span class="purpose-badge">{{ $purpose }}</span>@endforeach
      </td>
      <td>{{ Illuminate\Support\Str::limit($record->findings, 90) }}</td>
      <td><span class="patient-meta">BP</span> {{ $record->bp ?: '—' }}<br>
        <span class="patient-meta">Temp</span> {{ $record->temp ?: '—' }}<br>
        <span class="patient-meta">Pulse</span> {{ $record->pulse ?: '—' }}</td>
      <td><span class="waiting-badge">For Doctor</span></td>
      <td><a class="btn btn-primary btn-sm btn-open" href="{{ route('medical.doctor-consultation', $record->id) }}">Open Consultation</a> </td>
    </tr>
      @endforeach
    </tbody>
  </table>
</div>
    <div class="queue-footer">{{ $consultations->links() }}</div>
    @else
    <div class="queue-empty"><i class="bx bx-clipboard-check"></i><h5 class="mt-2">No consultations waiting</h5><div>{{ $search ? 'No patient matched your search.' : 'New nurse intake records will appear here.' }}</div></div>
    @endif
  </div>
</div>
@endsection
