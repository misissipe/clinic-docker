@extends('layouts.contentLayoutMaster')
@section('title', 'Consultation Record')

@section('content')
@php
  $patientName = trim(implode(' ', array_filter([
    $patient->FirstName ?? null,
    $patient->MiddleName ?? null,
    $patient->LastName ?? null,
  ])));
  $selected = json_decode($medical->purpose, true) ?: [];
@endphp

<style>
  .consult-record{max-width:1180px;margin:0 auto 32px}.consult-card{overflow:hidden;background:#fff;border:1px solid #dfe7f2;border-radius:16px;box-shadow:0 16px 40px rgba(35,62,99,.10)}.consult-head{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:22px 28px;background:linear-gradient(135deg,#4e83d7,#76a2e3);color:#fff}.patient-heading{display:flex;align-items:center;gap:14px}.patient-heading i{font-size:38px}.patient-heading h3{margin:0;color:#fff;font-weight:700}.patient-heading small{display:block;margin-top:3px;color:rgba(255,255,255,.85)}.record-status{padding:7px 13px;border:1px solid rgba(255,255,255,.45);border-radius:18px;background:rgba(255,255,255,.16);font-size:12px;font-weight:700}.consult-body{padding:28px}.section{margin-bottom:25px}.section-title{display:flex;align-items:center;gap:8px;margin-bottom:12px;color:#36577f;font-size:12px;font-weight:800;letter-spacing:.35px;text-transform:uppercase}.section-title i{font-size:17px;color:#5a8dee}.date-strip{display:grid;grid-template-columns:repeat(2,minmax(180px,230px));justify-content:end;gap:10px;margin-bottom:25px}.date-box{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid #dce5f0;border-radius:9px;background:#f9fbfe;color:#456383;font-weight:600}.purpose-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px 18px}.purpose-option{display:flex;align-items:center;gap:9px;margin:0;padding:10px 12px;border:1px solid #e1e8f1;border-radius:9px;background:#fbfcfe;color:#45617f;font-weight:600}.purpose-option:has(input:checked){border-color:#8eb4ed;background:#eef5ff;color:#2f68b8}.purpose-option input{width:17px;height:17px}.read-panel{min-height:86px;padding:15px;border:1px solid #dce5ef;border-radius:10px;background:#fbfcfe;color:#455d78;white-space:pre-line}.vitals-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}.vital{padding:14px;border:1px solid #dfe7f1;border-radius:10px;background:#fbfcfe}.vital small{display:block;margin-bottom:5px;color:#8292a7;font-size:10px;font-weight:700;text-transform:uppercase}.vital strong{color:#36577f;font-size:16px}.recommendation{min-height:110px;border-color:#d9e3ef;border-radius:10px;color:#405a78}.medicine-box{overflow:hidden;border:1px solid #dce5ef;border-radius:11px}.medicine-table{width:100%;margin:0}.medicine-table th{padding:10px 12px;background:#f1f6fc;color:#526d8d;font-size:10px;text-transform:uppercase}.medicine-table td{padding:12px;border-top:1px solid #e8edf4;color:#455f7c}.instruction-box{padding:13px 15px;border-top:1px solid #e0e8f2;background:#fff9e9;color:#695522}.consult-actions{display:flex;justify-content:flex-end;gap:10px;padding-top:5px}.consult-actions .btn{min-width:145px;border-radius:9px}.empty-medicine{padding:20px;color:#8492a4;text-align:center}@media(max-width:900px){.vitals-grid{grid-template-columns:repeat(2,1fr)}.purpose-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:600px){.consult-head{align-items:flex-start;flex-direction:column}.consult-body{padding:20px}.date-strip,.purpose-grid,.vitals-grid{grid-template-columns:1fr}.date-strip{justify-content:stretch}}
</style>

<div class="consult-record">
  <div class="consult-card">
    <div class="consult-head">
      <div class="patient-heading">
        <i class="bx bx-id-card"></i>
        <div>
          <h3>{{ $patientName ?: 'Patient '.$medical->patientId }}</h3>
          <small>{{ $medical->patientId }} · {{ $medical->role }} · Record #{{ $medical->id }}</small>
        </div>
      </div>
      {{-- <span class="record-status">For Nurse Completion</span> --}}
    </div>

    <form method="POST" action="{{ route('medical.nurse-treatment.save', $medical->id) }}" class="consult-body">
      @csrf
      @if($errors->any())
        <div class="alert alert-danger">Please review the required fields.</div>
      @endif

      @foreach($selected as $purpose)
        <input type="hidden" name="purpose[]" value="{{ $purpose }}">
      @endforeach
      <input type="hidden" name="recommendation" value="{{ $medical->recommendation }}">

      <div class="section">
        <div class="section-title"><i class="bx bx-plus-medical"></i> Prescribed Medicine</div>
        <div class="medicine-box">
          @if($doctorConsultations->count())
            <div class="table-responsive">
              <table class="medicine-table">
                <thead><tr><th>Medicine</th><th>Qty</th><th>Dose</th><th>Route</th><th>Frequency</th><th>Duration</th></tr></thead>
                <tbody>
                @foreach($doctorConsultations as $consultation)
                  <tr><td><strong>{{ $consultation->medicine_name }}</strong></td><td>{{ $consultation->quantity ?: '—' }}</td><td>{{ $consultation->dose ?: '—' }}</td><td>{{ $consultation->route ?: '—' }}</td><td>{{ $consultation->frequency ?: '—' }}</td><td>{{ $consultation->duration ?: '—' }}</td></tr>
                @endforeach
                </tbody>
              </table>
            </div>
            @if($doctorConsultations->first()->instruction)
              <div class="instruction-box"><strong>Patient instructions:</strong> {{ $doctorConsultations->first()->instruction }}</div>
            @endif
            <input type="hidden" name="has_medicine" value="1">
          @else
            <div class="empty-medicine">No medicine prescribed.</div>
          @endif
        </div>
      </div>

      <div class="consult-actions">
        <a href="{{ route('medical.consultation-records') }}" class="btn btn-light">Cancel</a>
        <button class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
@endsection
