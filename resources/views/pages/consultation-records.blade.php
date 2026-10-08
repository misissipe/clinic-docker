@extends('layouts.contentLayoutMaster')
@section('title', 'Consultation Record')

@section('vendor-styles')
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  .record-page{width:100%;max-width:none;margin:0}
  .record-header{
    background:linear-gradient(135deg,#356fc5,#6799df);
    color:#fff;
    border-radius:14px;
    padding:24px 26px;
    margin-bottom:18px;
    box-shadow:0 8px 24px rgba(45,91,155,.16)
  }
  .record-header h3{
    color:#fff;
    margin:0 0 4px;
    font-weight:700
  }
  .record-card{
    background:#fff;
    border:1px solid #e3e9f2;
    border-radius:14px;
    box-shadow:0 8px 28px rgba(35,58,92,.07);
    overflow:hidden
  }
  .record-tools{
    padding:18px 20px;
    border-bottom:1px solid #edf1f6;
    display:flex;
    justify-content:space-between;
    align-items:center;gap:16px
  }
  .search-form{
    display:flex;
    gap:8px;
    width:390px;
    max-width:100%
  }
  .record-table{
    margin:0
  }
  .record-table thead th{
    background:#f5f8fc;
    color:#536b89;
    border:0;
    font-size:11px;
    text-transform:uppercase;
    padding:13px
  }
  .record-table td{
    padding:14px 13px;
    border-color:#edf1f5;
    vertical-align:middle;
    color:#52657d
  }
  .patient-name{
    font-weight:700;
    color:#203f69
  }
  .patient-meta{
    font-size:11px;
    color:#8794a5
  }
  .ready-badge{
    background:#e7f8ee;
    color:#247a48;
    border-radius:20px;
    padding:6px 10px;
    font-size:11px;
    font-weight:700
  }
  .record-empty{
    text-align:center;
    padding:70px 20px;
    color:#8390a3
  }
  .record-footer{
    padding:14px 20px;
    border-top:1px solid #edf1f5
  }
  @media(max-width:767px)
  {
    .record-tools
    {
      align-items:stretch;
      flex-direction:column
    }
    .search-form
    {
      width:100%
    }
  }
  .record-card .dataTables_wrapper > .row { margin: 0; padding: 16px 12px; }
  .record-card .dataTables_wrapper > .row:nth-child(2) { padding: 0; }
  .record-card .dataTables_wrapper > .row:nth-child(2) > div { padding: 0; }
  .record-card .dataTables_filter input { border: 1px solid #dbe3ed; border-radius: 4px; }
</style>
<div class="record-page">
  <div class="record-header">
    <h3>Consultation Record</h3>
    <div>Patients consulted by the doctor and ready for nurse completion.</div>
  </div>
  <div class="record-card">
    <div class="record-tools">
      <div><strong>{{ $consultations->count() }}</strong> patient{{ $consultations->count() === 1 ? '' : 's' }} ready</div>

    </div>
      <div class="table-responsive">
        <table id="consultationRecordsTable" class="table record-table">
          <thead>
            <tr>
              <th>Patient</th>
              <th>Date &amp; Time</th>
              <th>Chief Complaint / Findings</th>
              <th>Doctor's Recommendation</th>
              <th>Medicine</th>
              <th>Status</th>
              <th>Action</th></tr></thead>
          <tbody>
          @foreach($consultations as $record)
            @php $fullName = trim($record->patient_first_name.' '.$record->patient_middle_name.' '.$record->patient_last_name); @endphp
            <tr>
              <td><div class="patient-name">{{ $fullName ?: 'Patient '.$record->patientId }}</div><div class="patient-meta">{{ $record->patientId }} · {{ $record->role }}</div></td>
              <td data-order="{{ $record->date }} {{ $record->time }}">{{ date('M d, Y', strtotime($record->date)) }}<div class="patient-meta">{{ $record->time ? date('h:i A', strtotime($record->time)) : '—' }}</div></td>
              <td>{{ Illuminate\Support\Str::limit($record->findings, 90) }}</td>
              <td>{{ Illuminate\Support\Str::limit($record->recommendation, 100) }}</td>
              <td>{{ $record->prescribed_medicines ?: '—' }}</td>
              <td><span class="ready-badge">For Nurse</span></td>
              <td><a class="btn btn-primary btn-sm" href="{{ route('medical.nurse-treatment', $record->id) }}">Complete Treatment</a></td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

  </div>
</div>
@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: @json(session('success')),
      confirmButtonText: 'OK',
      confirmButtonColor: '#5a8dee'
    });
  });
</script>
@endif
@endsection

@section('vendor-scripts')
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
@endsection

@section('page-scripts')
<script>
$(function () {
  $('#consultationRecordsTable').DataTable({
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    order: [[1, 'asc']],
    autoWidth: false,
    search: { search: @json($search) },
    columnDefs: [{ targets: 6, orderable: false, searchable: false }],
    language: {
      search: 'Search:',
      searchPlaceholder: 'Patient name or ID',
      emptyTable: 'No consultation records ready. Doctor-completed consultations will appear here.',
      zeroRecords: 'No records matched your search.'
    }
  });
});
</script>
@endsection
