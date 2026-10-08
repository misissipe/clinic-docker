@extends('layouts.contentLayoutMaster')
@section('title', 'Appointment Status')

@section('vendor-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
<style>
  .status-page{
    color:#10275b
  }
  .status-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:18px;
    margin-bottom:18px
  }

  .status-head h2{
    font-size:27px;
    font-weight:800;
    margin:0 0 5px
  }
  
  .status-head p{
    color:#6a7894;
    margin:0
  }

  .status-date{
    background:#edf4ff;
    color:#0758e8;
    border-radius:10px;
    padding:10px 14px;
    font-weight:700;
    white-space:nowrap
  }

  .status-cards{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:12px;
    margin-bottom:18px
  }

  .status-filter{
    appearance:none;
    text-align:left;
    background:#fff;
    border:1px solid #dfe7f3;
    min-height:86px;
    border-radius:13px;
    padding:15px 18px;
    cursor:pointer;
    box-shadow:0 5px 16px rgba(18,48,96,.04);
    transition:.18s
  }

  .status-filter:hover,.status-filter.active{
    border-color:#0758e8;
    box-shadow:0 6px 20px rgba(7,88,232,.12);
    transform:translateY(-1px)
  }

  .status-filter span{
    display:block;
    color:#6a7894;
    font-size:11px;
    font-weight:800;
    line-height:1.2;
    white-space:nowrap;
    text-transform:uppercase
  }
  .status-filter b{
    display:block;
    color:#10275b;
    font-size:25px;l
    ine-height:1.1;
    margin-top:8px
  }

  .status-filter.for-approval{
    border-left:4px solid #f07800;
    background:#fff8ed}
  .status-filter.pending{
    border-left:4px solid #e09a00
  }
  .status-filter.approved{
    border-left:4px solid #159751
  }
  .status-filter.disapproved{
    border-left:4px solid #cf3347
  }
  .status-filter.rescheduled{
    border-left:4px solid #7953c6
  }
  .status-filter.no-show{
    border-left:4px solid #d35b21
  }
  .status-filter.done{
    border-left:4px solid #16836b
  }
  .status-filter.cancelled{
    border-left:4px solid #8a96aa
  }
  .status-filter.all{
    border-left:4px solid #0758e8
  }
  .status-panel{
    background:#fff;
    border:1px solid #dfe7f3;
    border-radius:15px;
    box-shadow:0 6px 22px rgba(18,48,96,.06);
    overflow:hidden
  }
  .status-toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    padding:17px 19px;
    border-bottom:1px solid #e5ebf4
  }
  .status-toolbar h3{
    font-size:17px;
    font-weight:800;
    margin:0
  }
  .status-toolbar-controls{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:8px
  }
  .status-select,.status-search{
    height:40px;
    background:#fff;
    border:1px solid #d7e0ee;
    border-radius:9px;padding:0 12px;
    color:#10275b
  }
  .status-select{
    min-width:125px
  }
  .status-search{
    width:270px;max-width:100%
  }
  .status-table-wrap{
    overflow-x:auto
  }
  .status-table{
    width:100%;
    border-collapse:collapse
  }
  .status-table th{
    background:#f5f8fd;
    color:#596984;
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.03em;
    text-align:left;
    padding:12px 14px
  }
  .status-table td{
    border-top:1px solid #edf1f7;
    padding:13px 14px;
    vertical-align:middle
  }
  .status-table tbody tr:hover{background:#fbfdff}
  .patient-name{
    font-weight:750;
    color:#10275b
  }
  .patient-meta,.service-meta{
    color:#71809a;
    font-size:11px;
    margin-top:3px
  }
  .service-name{
    font-weight:650;
    color:#344b70;
    max-width:260px
  }
  .remarks-cell{
    color:#52617b;
    max-width:220px;
    white-space:normal
  }
  .status-pill{
    display:inline-block;
    border-radius:20px;
    padding:5px 10px;
    font-size:14px;
    font-weight:800;
  }
  .status-pill.for-approval{
    background:#ffe0b2;
    color:#9a4300;
    border:1px solid #ffbd66
  }
  .status-pill.pending{
    background:#fff2cf;
    color:#865a00
  }
  .status-pill.approved{
    background:#e0f5e8;
    color:#14743d
  }
  .status-pill.disapproved{
    background:#ffe5e8;
    color:#b42335
  }
  .status-pill.rescheduled{
    background:#f1eaff;
    color:#6440ad
  }.status-pill.no-show{
    background:#fff0e8;
    color:#a33c10
  }
  .status-pill.done{
    background:#def7f0;
    color:#116b59
  }
  .status-pill.cancelled,.status-pill.canceled{
    background:#edf0f4;color:#596984
  }
  .reason{
    color:#b42335;
    font-size:11px;
    margin-top:4px;
    max-width:220px
  }
  .schedule-cell{
    white-space:nowrap;
    color:#344b70
  }
  .schedule-cell b{
    display:block;
    color:#10275b
  }
  .action-group{
    display:flex;
    flex-direction:column;
    align-items:stretch;
    gap:6px;
    min-width:125px
  }
  .action-btn{
    border:1px solid transparent;
    border-radius:7px;
    padding:7px 9px;
    font-size:11px;
    font-weight:750;
    cursor:pointer;
    white-space:nowrap;
    text-align:center;
    transition:background .18s,border-color .18s,transform .18s
  }
  .action-btn:hover{
    transform:translateY(-1px)
  }
  .action-btn.approve,.action-btn.complete{
    background:#e0f5e8;
    color:#14743d
  }
  .action-btn.disapprove,.action-btn.no-show{
    background:#ffe5e8;
    color:#b42335
  }
  .action-btn.reschedule{
    background:#f1eaff;
    color:#6440ad
  }
  .action-btn.edit-service{background:#e8f1ff;color:#0758e8}
  .action-btn.cancel-reschedule{
    background:#fff;
    color:#b42335;
    border-color:#f0bdc4
  }
  .action-btn.cancel-reschedule:hover{
    background:#fff2f4;
    border-color:#dc8793
  }
  .action-done{
    color:#8a96aa;
    font-size:11px
  }
  .reschedule-fields{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
    text-align:left;
    margin-top:12px
  }
  .reschedule-fields label{
    display:block;
    color:#52617b;
    font-size:12px;
    font-weight:700;
    margin-bottom:5px
  }
  .reschedule-fields input{
    width:100%;border:1px solid #d7e0ee;
    border-radius:8px;
    padding:9px 10px;
    color:#10275b
  }
  .status-empty{text-align:center;color:#7b879c;padding:35px!important}
  @media(max-width:1100px){.status-cards{grid-template-columns:repeat(4,1fr)}}
  @media(max-width:650px){.status-head,.status-toolbar{align-items:flex-start;flex-direction:column}.status-cards{grid-template-columns:repeat(2,1fr)}.status-toolbar-controls{width:100%;flex-wrap:wrap;justify-content:flex-start}.status-select{flex:1}.status-search{width:100%}}
</style>
@endsection

@section('content')
@php
  $formatPurpose = function ($purpose) {
      if ($purpose === null || (!is_array($purpose) && trim((string) $purpose) === '')) return '—';

      // Some older records contain a JSON list encoded more than once.
      // Unwrap each valid JSON layer before displaying the service names.
      $decoded = $purpose;
      for ($attempt = 0; $attempt < 3 && is_string($decoded); $attempt++) {
          $next = json_decode($decoded, true);
          if (json_last_error() !== JSON_ERROR_NONE) break;
          $decoded = $next;
      }

      if (is_array($decoded)) {
          return implode(', ', array_map(function ($service) {
              return trim((string) $service);
          }, $decoded));
      }

      return trim((string) $decoded);
  };
@endphp

<section class="status-page">
  <div class="status-head">
    <div>
      <h2>Appointment Requests & Status</h2>
      <p>Review patient requests and monitor every appointment status.</p>
    </div>
    <div class="status-date"><i class="fa fa-calendar"></i> {{ now()->format('F d, Y') }}</div>
  </div>

  <div class="status-cards" role="group" aria-label="Filter appointments by status">
    <button type="button" class="status-filter pending active" data-filter="pending"><span>Pending</span><b>{{ $statusCounts['pending'] }}</b></button>
    <button type="button" class="status-filter approved" data-filter="approved"><span>Approved</span><b>{{ $statusCounts['approved'] }}</b></button>
    <button type="button" class="status-filter disapproved" data-filter="disapproved"><span>Disapproved</span><b>{{ $statusCounts['disapproved'] }}</b></button>
    <button type="button" class="status-filter rescheduled" data-filter="rescheduled"><span>Rescheduled</span><b>{{ $statusCounts['rescheduled'] }}</b></button>
    <button type="button" class="status-filter all" data-filter="all"><span>All Requests</span><b>{{ $statusCounts['all'] }}</b></button>
  </div>

  <div class="status-panel">
    <div class="status-toolbar">
      <h3 id="statusListTitle">Pending Appointments</h3>
      <div class="status-toolbar-controls">
        <select id="statusMonth" class="status-select" aria-label="Filter by month">
          <option value="">All months</option>
          @foreach(range(1, 12) as $month)
            <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
          @endforeach
        </select>
        <select id="statusYear" class="status-select" aria-label="Filter by year">
          <option value="">All years</option>
          @foreach($statusAppointments->filter(function ($appointment) { return !empty($appointment->date); })->map(function ($appointment) { return date('Y', strtotime($appointment->date)); })->unique()->sortDesc() as $year)
            <option value="{{ $year }}">{{ $year }}</option>
          @endforeach
        </select>
        <input id="statusSearch" class="status-search" type="search" placeholder="Search patient, ID, type, service, or remarks">
      </div>
    </div>
    <div class="status-table-wrap">
      <table id="statusAppointmentsTable" class="status-table">
        <thead>
          <tr>
            <th>Patient</th>
            <th>Type / ID</th>
            <th>Service</th>
            <th>Remarks</th>
            <th>Schedule</th>
            <th>New Scheduled Date</th>
            <th>Status / Reason</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="statusRows">
          @foreach($statusAppointments as $data)
            @php
              $statusKey = in_array($data->status, ['Pending', 'For Approval'], true)
                ? 'pending'
                : (in_array($data->status, ['Cancelled', 'Canceled'], true)
                  ? 'cancelled'
                  : str_replace(' ', '-', strtolower((string) $data->status)));
              $isRescheduled = $statusKey === 'rescheduled';
              $originalScheduleDate = $isRescheduled && !empty($data->original_date) ? $data->original_date : $data->date;
              $originalScheduleTime = $isRescheduled && !empty($data->original_time) ? $data->original_time : $data->time;
              $originalScheduleOrder = $originalScheduleDate
                ? date('Y-m-d', strtotime($originalScheduleDate)).' '.($originalScheduleTime ?: '00:00:00')
                : '9999-12-31 23:59:59';
              $newScheduleOrder = $isRescheduled && $data->date
                ? date('Y-m-d', strtotime($data->date)).' '.($data->time ?: '00:00:00')
                : '9999-12-31 23:59:59';
              $currentServices = json_decode($data->purpose, true);
              if (!is_array($currentServices)) $currentServices = array_filter([(string) $data->purpose]);
            @endphp
            <tr data-status="{{ $statusKey }}" data-month="{{ $data->date ? (int) date('n', strtotime($data->date)) : '' }}" data-year="{{ $data->date ? date('Y', strtotime($data->date)) : '' }}" data-search="{{ strtolower(trim($data->firstname.' '.$data->middlename.' '.$data->lastname).' '.$data->patientId.' '.$data->role.' '.$formatPurpose($data->purpose).' '.($data->remarks ?? '')) }}">
              <td>
                <div class="patient-name">{{ trim($data->firstname.' '.$data->middlename.' '.$data->lastname) }}</div>
                <div class="patient-meta">{{ $data->contactNo ?: 'No contact number' }}</div>
              </td>
              <td>
                <b>{{ $data->role ?: '—' }}</b>
                <div class="patient-meta">{{ $data->patientId ?: 'No ID' }}</div>
              </td>
              <td>
                <div class="service-name">{{ $formatPurpose($data->purpose) }}</div>
              </td>
              <td class="remarks-cell">{{ $data->remarks ?: '—' }}</td>
              <td class="schedule-cell" data-order="{{ $originalScheduleOrder }}">
                <b>{{ $originalScheduleDate ? date('M d, Y', strtotime($originalScheduleDate)) : '—' }}</b>
                {{ $originalScheduleTime ? date('h:i A', strtotime($originalScheduleTime)) : '—' }}
              </td>
              <td class="schedule-cell" data-order="{{ $newScheduleOrder }}">
                @if($isRescheduled)
                  <b>{{ $data->date ? date('M d, Y', strtotime($data->date)) : '—' }}</b>
                  {{ $data->time ? date('h:i A', strtotime($data->time)) : '—' }}
                @else
                  <span class="patient-meta">—</span>
                @endif
              </td>
              <td>
                <span class="status-pill {{ $statusKey }}">{{ $data->status }}</span>
                @if($statusKey === 'disapproved')<div class="reason">
                  <b>Reason:</b> {{ $data->remarks ?: 'No reason provided.' }}
                </div>
                @elseif($statusKey === 'rescheduled')
                <div class="reason" style="color:#6440ad">
                  <b>Reason:</b> {{ $data->remarks ?: 'No reason provided.' }}
                </div>
                @elseif(in_array($statusKey, ['cancelled', 'canceled'], true))
                <div class="reason">
                  <b>Reason:</b> {{ $data->remarks ?: 'No reason provided.' }}
                </div>
                @endif
              </td>
              <td>
                @if(in_array($statusKey, ['for-approval', 'pending'], true))
                  <div class="action-group"><button type="button" class="action-btn approve" data-id="{{ $data->id }}" data-status="Approved"><i class="fa fa-check"></i> Approve</button><button type="button" class="action-btn disapprove" data-id="{{ $data->id }}" data-status="Disapproved"><i class="fa fa-times"></i> Disapprove</button><button type="button" class="action-btn reschedule" data-id="{{ $data->id }}" data-date="{{ $data->date ? date('Y-m-d', strtotime($data->date)) : '' }}" data-time="{{ $data->time ? date('H:i', strtotime($data->time)) : '' }}"><i class="fa fa-calendar"></i> Reschedule</button></div>
                @elseif($statusKey === 'approved')
                  <div class="action-group"><button type="button" class="action-btn edit-service" data-id="{{ $data->id }}" data-services='@json($currentServices)'><i class="fa fa-pencil"></i> Edit Service</button><button type="button" class="action-btn complete" data-id="{{ $data->id }}"><i class="fa fa-check-circle"></i> Done</button><button type="button" class="action-btn no-show" data-id="{{ $data->id }}"><i class="fa fa-user-times"></i> No Show</button><button type="button" class="action-btn reschedule" data-id="{{ $data->id }}" data-date="{{ $data->date ? date('Y-m-d', strtotime($data->date)) : '' }}" data-time="{{ $data->time ? date('H:i', strtotime($data->time)) : '' }}"><i class="fa fa-calendar"></i> Reschedule</button></div>
                @elseif($statusKey === 'rescheduled')
                  <div class="action-group">
                    <button type="button" class="action-btn reschedule edit-schedule" data-id="{{ $data->id }}" data-date="{{ $data->date ? date('Y-m-d', strtotime($data->date)) : '' }}" data-time="{{ $data->time ? date('H:i', strtotime($data->time)) : '' }}" data-reason="{{ $data->remarks ?? '' }}"><i class="fa fa-calendar"></i> Reschedule Date</button>
                    <button type="button" class="action-btn cancel-reschedule" data-id="{{ $data->id }}"><i class="fa fa-times"></i> Cancel Reschedule</button>
                  </div>
                @else
                  <span class="action-done">No action required</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection

@section('vendor-scripts')
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('page-scripts')
<script>
$(function () {
  var currentFilter = 'pending';
  var titles = {
    pending:'Pending Appointments',
    approved:'Approved Appointments',
    disapproved:'Disapproved Appointments',
    rescheduled:'Rescheduled Appointments',
    'no-show':'No Show Appointments',
    done:'Completed Appointments',
    cancelled:'Cancelled Appointments',
    all:'All Appointment Requests'
  };
  var statusTable = $('#statusAppointmentsTable').DataTable({
    pageLength: 10,
    lengthChange: false,
    order: [[4, 'desc'], [5, 'desc']],
    columnDefs: [{targets: 7, orderable: false}],
    dom: "rt<'d-flex flex-wrap justify-content-between align-items-center p-2'ip>",
    language: {emptyTable: 'No appointment requests found.', zeroRecords: 'No appointments match this view.', infoFiltered: ''}
  });

  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    if (settings.nTable.id !== 'statusAppointmentsTable') return true;
    var row = $(statusTable.row(dataIndex).node());
    var rowStatus = row.data('status');
    var selectedMonth = $('#statusMonth').val();
    var selectedYear = $('#statusYear').val();
    var matchesStatus = currentFilter === 'all' || rowStatus === currentFilter;
    var matchesMonth = !selectedMonth || String(row.data('month')) === selectedMonth;
    var matchesYear = !selectedYear || String(row.data('year')) === selectedYear;
    return matchesStatus && matchesMonth && matchesYear;
  });

  function applyFilters() {
    var search = ($('#statusSearch').val() || '').toLowerCase().trim();
    var ascendingFilters = ['pending', 'approved', 'disapproved', 'rescheduled'];
    var scheduleDirection = ascendingFilters.indexOf(currentFilter) !== -1 ? 'asc' : 'desc';
    statusTable.search(search).order([[4, scheduleDirection], [5, scheduleDirection]]).page('first').draw();
  }

  $('.status-filter').on('click', function () {
    currentFilter = $(this).data('filter');
    $('.status-filter').removeClass('active');
    $(this).addClass('active');
    $('#statusListTitle').text(titles[currentFilter]);
    applyFilters();
  });
  $('#statusSearch').on('input', applyFilters);
  $('#statusMonth, #statusYear').on('change', applyFilters);
  applyFilters();

  function updateStatus(id, status, remarks) {
    return $.ajax(
      {
        url:'/setStatus',
        type:'POST',
        data:{id:id,status:status,stat_remarks:remarks || '',_token:'{{ csrf_token() }}'}
      });
  }

  $(document).on('click', '.action-btn.approve', function () {
    var button = $(this);
    Swal.fire({title:'Approve appointment?',text:'The patient request will be approved.',icon:'question',showCancelButton:true,confirmButtonText:'Approve'}).then(function (result) {
      if (!result.isConfirmed) return;
      updateStatus(button.data('id'), 'Approved').done(function (response) { if(response.success){Swal.fire('Approved',response.success,'success').then(function(){location.reload();});}else{Swal.fire('Error',response.error || 'Unable to approve.','error');} });
    });
  });

  $(document).on('click', '.action-btn.disapprove', function () {
    var button = $(this);
    Swal.fire({title:'Disapprove appointment',input:'textarea',inputLabel:'Reason for disapproval',inputPlaceholder:'Enter the reason shown to the patient',showCancelButton:true,confirmButtonText:'Disapprove',inputValidator:function(value){if(!value || !value.trim()) return 'A reason is required.';}}).then(function (result) {
      if (!result.isConfirmed) return;
      updateStatus(button.data('id'), 'Disapproved', result.value).done(function (response) { if(response.success){Swal.fire('Disapproved',response.success,'success').then(function(){location.reload();});}else{Swal.fire('Error',response.error || 'Unable to disapprove.','error');} });
    });
  });

  $(document).on('click', '.action-btn.edit-service', function () {
    var button = $(this);
    var selected = [];

    try {
      selected = JSON.parse(button.attr('data-services') || '[]');
    } catch (error) {
      selected = [];
    }

    var services = ['Consultation', 'Oral Restoration', 'Oral Prophylaxis', 'Tooth Extraction'];
    var choices = services.map(function (service, index) {
      var checked = selected.indexOf(service) !== -1 ? ' checked' : '';
      return '<label for="editService' + index + '" style="display:flex;align-items:center;gap:9px;padding:8px 4px;text-align:left;cursor:pointer">' +
        '<input id="editService' + index + '" class="edit-service-choice" type="checkbox" value="' + service + '"' + checked + '>' +
        '<span>' + service + '</span></label>';
    }).join('');

    Swal.fire({
      title:'Edit services rendered',
      html:'<div style="padding:4px 18px">' + choices + '</div>',
      showCancelButton:true,
      confirmButtonText:'Save Services',
      confirmButtonColor:'#0758e8',
      focusConfirm:false,
      preConfirm:function () {
        var values = $('.edit-service-choice:checked').map(function () {
          return this.value;
        }).get();

        if (!values.length) {
          Swal.showValidationMessage('Select at least one service.');
          return false;
        }

        return values;
      }
    }).then(function (result) {
      if (!result.isConfirmed) return;

      $.ajax({
        url:'{{ route('appointment.update-services') }}',
        type:'POST',
        data:{id:button.data('id'),services:result.value,_token:'{{ csrf_token() }}'}
      }).done(function (response) {
        Swal.fire('Updated', response.success, 'success').then(function () { location.reload(); });
      }).fail(function (xhr) {
        var response = xhr.responseJSON || {};
        var validationError = response.errors ? Object.values(response.errors)[0][0] : '';
        Swal.fire('Unable to update services', response.error || validationError || 'Please try again.', 'error');
      });
    });
  });

  $(document).on('click', '.action-btn.complete, .action-btn.no-show', function () {
    var button = $(this);
    var status = button.hasClass('complete') ? 'Done' : 'No Show';
    var isDone = status === 'Done';

    Swal.fire({
      title:isDone ? 'Mark appointment as done?' : 'Mark patient as no show?',
      text:isDone ? 'This confirms that the appointment was completed.' : 'This confirms that the patient did not attend the appointment.',
      icon:'question',
      showCancelButton:true,
      confirmButtonText:isDone ? 'Mark Done' : 'Mark No Show',
      confirmButtonColor:isDone ? '#159751' : '#cf3347'
    }).then(function (result) {
      if (!result.isConfirmed) return;
      updateStatus(button.data('id'), status).done(function (response) {
        if (response.success) {
          Swal.fire(status, response.success, 'success').then(function(){location.reload();});
        } else {
          Swal.fire('Error', response.error || 'Unable to update the appointment.', 'error');
        }
      }).fail(function (xhr) {
        var response = xhr.responseJSON || {};
        Swal.fire('Unable to update', response.error || 'Please try again.', 'error');
      });
    });
  });

  $(document).on('click', '.action-btn.reschedule', function () {
    var button = $(this);
    var isEditing = button.hasClass('edit-schedule');
    var today = @json(now('Asia/Manila')->toDateString());

    Swal.fire({
      title:isEditing ? 'Edit rescheduled appointment' : 'Reschedule appointment',
      html:'<div class="reschedule-fields"><div><label for="rescheduleDate">New date</label><input id="rescheduleDate" type="date" min="' + today + '" value="' + (button.data('date') || '') + '"></div><div><label for="rescheduleTime">New time</label><input id="rescheduleTime" type="time" value="' + (button.data('time') || '') + '"></div><div style="grid-column:1/-1"><label for="rescheduleReason">Reason for rescheduling</label><textarea id="rescheduleReason" maxlength="255" rows="3" placeholder="Enter the reason" style="width:100%;border:1px solid #d7e0ee;border-radius:8px;padding:9px 10px;resize:vertical"></textarea></div></div>',
      showCancelButton:true,
      confirmButtonText:isEditing ? 'Save Changes' : 'Reschedule',
      confirmButtonColor:'#7953c6',
      focusConfirm:false,
      didOpen:function () {
        if (isEditing) $('#rescheduleReason').val(button.attr('data-reason') || '');
      },
      preConfirm:function () {
        var date = $('#rescheduleDate').val();
        var time = $('#rescheduleTime').val();
        var reason = ($('#rescheduleReason').val() || '').trim();
        if (!date || !time) {
          Swal.showValidationMessage('Please select both a new date and time.');
          return false;
        }
        if (!reason) {
          Swal.showValidationMessage('Please provide a reason for rescheduling.');
          return false;
        }
        if (date < today) {
          Swal.showValidationMessage('The new appointment date cannot be in the past.');
          return false;
        }
        return {date:date,time:time,reason:reason};
      }
    }).then(function (result) {
      if (!result.isConfirmed) return;
      $.ajax({
        url:'/reschedule',
        type:'POST',
        data:{id:button.data('id'),date:result.value.date,time:result.value.time,reschedule_reason:result.value.reason,_token:'{{ csrf_token() }}'}
      }).done(function (response) {
        Swal.fire('Rescheduled', response.success || 'Appointment rescheduled successfully!', 'success').then(function(){location.reload();});
      }).fail(function (xhr) {
        var response = xhr.responseJSON || {};
        var validationError = response.errors ? Object.values(response.errors)[0][0] : '';
        Swal.fire('Unable to reschedule', response.error || validationError || 'Please try again.', 'error');
      });
    });
  });

  $(document).on('click', '.action-btn.cancel-reschedule', function () {
    var button = $(this);

    Swal.fire({
      title:'Cancel this reschedule?',
      text:'The original appointment date and time will be restored.',
      icon:'warning',
      showCancelButton:true,
      confirmButtonText:'Cancel Reschedule',
      confirmButtonColor:'#b42335'
    }).then(function (result) {
      if (!result.isConfirmed) return;

      button.prop('disabled', true);
      $.ajax({
        url:'/cancel-reschedule',
        type:'POST',
        data:{id:button.data('id'),_token:'{{ csrf_token() }}'}
      }).done(function (response) {
        Swal.fire('Reschedule Cancelled', response.success, 'success').then(function(){location.reload();});
      }).fail(function (xhr) {
        button.prop('disabled', false);
        var response = xhr.responseJSON || {};
        var validationError = response.errors ? Object.values(response.errors)[0][0] : '';
        Swal.fire('Unable to cancel reschedule', response.error || validationError || 'Please try again.', 'error');
      });
    });
  });

});
</script>
@endsection
