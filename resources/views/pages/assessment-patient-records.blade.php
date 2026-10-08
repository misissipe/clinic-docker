@extends('layouts.contentLayoutMaster')
@section('title', 'Student Assessment History')

@section('vendor-styles')
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
@php
  $riskQuestions = [
    'Fever' => 'Fever',
    'SoreThroat' => 'Sore Throat',
    'Cough' => 'Cough',
    'Cold' => 'Runny Nose',
    'SOB' => 'Shortness Of Breath',
    'Chills' => 'Chills',
    'Nausea' => 'Nausea',
    'Diarrhea' => 'Diarrhea',
    'Headache' => 'Headaches',
    'JointAches' => 'Joint Aches',
    'MuscleAches' => 'Muscle Aches',
    'GenMal' => 'General Malaise',
    'LossApp' => 'Loss Of Appetite',
    'Allergy' => 'Allergies',
  ];
@endphp
<style>
  .assessment-header{background:linear-gradient(135deg,#356fc5,#6799df);color:#fff;border-radius:14px;padding:24px 26px;margin-bottom:18px;box-shadow:0 8px 24px rgba(45,91,155,.16)}
  .assessment-header h3{color:#fff;margin:0 0 4px;font-weight:700}
  .assessment-card{background:#fff;border:1px solid #e3e9f2;border-radius:14px;box-shadow:0 8px 28px rgba(35,58,92,.07);overflow:hidden}
  .assessment-summary{padding:18px 20px;border-bottom:1px solid #edf1f6;display:flex;justify-content:space-between;align-items:center;color:#52657d}
  .assessment-table{margin:0}
  .assessment-table thead th{background:#f5f8fc;color:#536b89;border:0;font-size:11px;text-transform:uppercase;padding:13px;white-space:nowrap}
  .assessment-table td{padding:14px 13px;border-color:#edf1f5;vertical-align:top;color:#52657d}
  .student-meta{font-size:11px;color:#8794a5}
  .factor-badge{display:inline-block;background:#edf4ff;color:#356fc5;border-radius:14px;padding:4px 8px;margin:2px;font-size:11px}
  .assessment-card .dataTables_wrapper>.row{margin:0;padding:16px 12px}
  .assessment-card .dataTables_wrapper>.row:nth-child(2){padding:0}
  .assessment-card .dataTables_wrapper>.row:nth-child(2)>div{padding:0}
  .assessment-table th:last-child,.assessment-table td:last-child{position:sticky;right:0;min-width:105px;z-index:2;box-shadow:-5px 0 10px rgba(35,58,92,.05)}
  .assessment-table th:last-child{z-index:3;background:#f5f8fc}
  .assessment-table td:last-child{background:#fff}
  .assessment-table tbody tr:nth-child(even) td:last-child{background:#fafbfc}
  .record-actions{display:flex;flex-direction:column;gap:6px;white-space:nowrap}
  .assessment-edit-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;text-align:left}
  .assessment-edit-grid .full{grid-column:1/-1}
  .assessment-edit-grid label{display:block;font-size:12px;font-weight:700;color:#536b89;margin-bottom:4px}
  .assessment-edit-grid input,.assessment-edit-grid textarea{width:100%;border:1px solid #d7e0ee;border-radius:7px;padding:8px 10px}
  .questionnaire-modal .modal-dialog{max-width:900px;margin:20px auto;height:calc(100vh - 40px)}
  .questionnaire-modal .modal-content{border:0;border-radius:8px;overflow:hidden;max-height:100%}
  .questionnaire-modal form{display:flex;flex-direction:column;max-height:calc(100vh - 40px)}
  .questionnaire-modal .modal-body{overflow-y:auto;overscroll-behavior:contain;min-height:0}
  .questionnaire-modal .modal-footer{flex:0 0 auto;background:#fff;box-shadow:0 -4px 12px rgba(35,58,92,.08)}
  .questionnaire-title{text-align:center;color:#3e5879;font-weight:800;font-size:23px;line-height:1.25;margin:0 0 12px}
  .questionnaire-table{width:100%;border-collapse:collapse;color:#111}
  .questionnaire-table th,.questionnaire-table td{border:1px solid #222;padding:14px 28px}
  .questionnaire-table th{text-align:center;font-size:16px}
  .questionnaire-table td:first-child{width:50%}
  .questionnaire-choice{display:inline-flex;align-items:center;margin-right:12px;gap:4px}
  .questionnaire-line{border:0;border-bottom:1px solid #888;border-radius:0;padding:4px 2px;width:65%;outline:0}
  .questionnaire-vitals{display:grid;grid-template-columns:auto 1fr auto 1fr;gap:8px;align-items:center}
  @media(max-width:767px){.questionnaire-table th,.questionnaire-table td{padding:10px}.questionnaire-vitals{grid-template-columns:auto 1fr}}
</style>

<div class="assessment-header">
  <h3>{{ $student->student_name }}</h3>
  <div>Student ID: {{ $student->StudentNo }}</div>
</div>

<div class="assessment-card">
  <div class="assessment-summary">
    <div><strong>{{ $records->count() }}</strong> assessment{{ $records->count() === 1 ? '' : 's' }}</div>
    <a href="{{ route('assessment.records') }}" class="btn btn-outline-primary btn-sm">Back to Students</a>
  </div>
  <div class="table-responsive">
    <table id="patientAssessmentTable" class="table assessment-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Risk Factors / Symptoms</th>
          <th>Vital Signs</th>
          <th>Service Availed</th>
          <th>Other Details</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($records as $record)
        <tr>
          <td data-order="{{ $record->created_at }}">
            {{ $record->created_at ? date('M d, Y', strtotime($record->created_at)) : '—' }}
          </td>
          <td>
            @forelse($record->risk_factors as $factor)
              <span class="factor-badge">{{ ucwords(str_replace(['_', '-'], ' ', $factor)) }}</span>
            @empty
              —
            @endforelse
          </td>
          <td>
            <div><strong>Temp:</strong> {{ $record->temp ?: '—' }}</div>
            <div><strong>BP:</strong> {{ $record->bp ?: '—' }}</div>
            <div><strong>Pulse:</strong> {{ $record->pulse_rate ?: '—' }}</div>
          </td>
          <td>{{ $record->service_availed ?: '—' }}</td>
          <td>
            <div><strong>Allergy:</strong> {{ $record->risk_others ?: '—' }}</div>
            <div><strong>Others:</strong> {{ $record->others ?: '—' }}</div>
          </td>
          <td>
            <div class="record-actions">
              <button type="button" class="btn btn-primary btn-sm edit-assessment"
                data-record="{{ json_encode([
                  "risk_factors" => $record->risk_factors,
                  "temp" => $record->temp,
                  "bp" => $record->bp,
                  "pulse_rate" => $record->pulse_rate,
                  "service_availed" => $record->service_availed,
                  "risk_others" => $record->risk_others,
                  "others" => $record->others
                ]) }}"
                data-url="{{ route('assessment.records.update', ['studentNo' => $student->StudentNo, 'assessmentId' => $record->id]) }}">
                <i class="fa fa-pencil"></i> Edit
              </button>
              <button type="button" class="btn btn-danger btn-sm delete-assessment"
                data-url="{{ route('assessment.records.delete', ['studentNo' => $student->StudentNo, 'assessmentId' => $record->id]) }}">
                <i class="fa fa-trash"></i> Delete
              </button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade questionnaire-modal" id="editAssessmentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <form id="editAssessmentForm">
        @csrf
        <input type="hidden" id="editAssessmentUrl">
        <div class="modal-body p-2">
          <h3 class="questionnaire-title">Assessment Questionnaire of Potential Risk Factors for<br>Viral/Bacterial Infection</h3>
          <table class="questionnaire-table">
            <thead><tr><th colspan="2">RISK FACTOR QUESTIONNAIRE</th></tr></thead>
            <tbody>
              <tr><td colspan="2">Please Indicate If You Have The Following Symptoms:</td></tr>
              @foreach($riskQuestions as $key => $label)
              <tr>
                <td>
                  {{ $label }}
                  @if($key === 'Allergy')<div>If Yes, Please Specify:</div>@endif
                </td>
                <td>
                  <label class="questionnaire-choice"><input type="radio" name="risk_answer[{{ $key }}]" value="yes_{{ $key }}"> Yes</label>
                  <label class="questionnaire-choice"><input type="radio" name="risk_answer[{{ $key }}]" value="no_{{ $key }}"> No</label>
                  @if($key === 'Allergy')<div><input class="questionnaire-line mt-1" id="editRiskOthers" type="text" maxlength="255"></div>@endif
                </td>
              </tr>
              @endforeach
              <tr><td colspan="2">Other Symptoms Not Included In The List:</td></tr>
              <tr><td colspan="2">(Please Specify): <input class="questionnaire-line" id="editOthers" type="text" maxlength="255"></td></tr>
              <tr>
                <td colspan="2">
                  <div class="questionnaire-vitals">
                    <label>Temperature:</label><input class="questionnaire-line" id="editTemp" type="text" maxlength="50">
                    <label>BP:</label><input class="questionnaire-line" id="editBp" type="text" maxlength="50">
                    <label>Pulse Rate:</label><input class="questionnaire-line" id="editPulse" type="text" maxlength="50">
                    <label>Service(s) Availed:</label><input class="questionnaire-line" id="editService" type="text" maxlength="255">
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Back</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('vendor-scripts')
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('page-scripts')
<script>
$(function () {
  $('#patientAssessmentTable').DataTable({
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    order: [[0, 'desc']],
    autoWidth: false,
    columnDefs: [{ targets: 5, orderable: false, searchable: false }],
    language: {
      emptyTable: 'This student has no assessment records.',
      zeroRecords: 'No assessment records matched your search.'
    }
  });

  $(document).on('click', '.edit-assessment', function () {
    var button = $(this);
    var record = button.data('record');

    $('#editAssessmentForm')[0].reset();
    $('#editAssessmentUrl').val(button.data('url'));
    (record.risk_factors || []).forEach(function (factor) {
      $('#editAssessmentForm input[type="radio"][value="' + factor + '"]').prop('checked', true);
    });
    $('#editTemp').val(record.temp || '');
    $('#editBp').val(record.bp || '');
    $('#editPulse').val(record.pulse_rate || '');
    $('#editService').val(record.service_availed || '');
    $('#editRiskOthers').val(record.risk_others || '');
    $('#editOthers').val(record.others || '');
    $('#editAssessmentModal').modal('show');
  });

  $('#editAssessmentForm').on('submit', function (event) {
    event.preventDefault();
    var factors = $(this).find('input[type="radio"]:checked').map(function () {
      return this.value;
    }).get();

    if (factors.length !== {{ count($riskQuestions) }}) {
      Swal.fire('Incomplete Questionnaire', 'Please answer Yes or No for every risk factor.', 'warning');
      return;
    }

    var submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true).text('Saving...');

    $.ajax({
      url: $('#editAssessmentUrl').val(),
      type: 'POST',
      data: {
        _method: 'PUT',
        _token: '{{ csrf_token() }}',
        risk_factors: factors,
        temp: $('#editTemp').val(),
        bp: $('#editBp').val(),
        pulse_rate: $('#editPulse').val(),
        service_availed: $('#editService').val(),
        risk_others: $('#editRiskOthers').val(),
        others: $('#editOthers').val()
      }
    }).done(function (response) {
      $('#editAssessmentModal').modal('hide');
      Swal.fire('Updated', response.success, 'success').then(function () { location.reload(); });
    }).fail(function (xhr) {
      var response = xhr.responseJSON || {};
      var validationError = response.errors ? Object.values(response.errors)[0][0] : '';
      Swal.fire('Unable to update', response.error || validationError || 'Please try again.', 'error');
    }).always(function () {
      submitButton.prop('disabled', false).text('Save');
    });
  });

  $(document).on('click', '.delete-assessment', function () {
    var button = $(this);

    Swal.fire({
      title: 'Delete assessment?',
      text: 'This assessment record will be permanently deleted.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete',
      confirmButtonColor: '#d33'
    }).then(function (result) {
      if (!result.isConfirmed) return;

      $.ajax({
        url: button.data('url'),
        type: 'POST',
        data: {_method: 'DELETE', _token: '{{ csrf_token() }}'}
      }).done(function (response) {
        Swal.fire('Deleted', response.success, 'success').then(function () { location.reload(); });
      }).fail(function (xhr) {
        var response = xhr.responseJSON || {};
        Swal.fire('Unable to delete', response.error || 'Please try again.', 'error');
      });
    });
  });
});
</script>
@endsection
