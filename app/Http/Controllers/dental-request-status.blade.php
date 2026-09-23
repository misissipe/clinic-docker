@php
    $requestStatus = $appointment ? strtolower(trim((string) $appointment->status)) : '';
    $requestStatus = $requestStatus === 'canceled' ? 'cancelled' : $requestStatus;
    $requestPurpose = $appointment
        ? (is_array($appointment->purpose) ? implode(', ', $appointment->purpose) : (string) $appointment->purpose)
        : '';
    $requestLabels = [
        'pending' => 'Pending', 'for approval' => 'For Approval',
        'approved' => 'Approved', 'confirmed' => 'Approved',
        'rescheduled' => 'Rescheduled', 'disapproved' => 'Disapproved',
        'cancelled' => 'Cancelled', 'done' => 'Done', 'completed' => 'Done',
    ];
    $requestLabel = $requestLabels[$requestStatus] ?? ($appointment ? ucfirst($requestStatus) : 'No Request');
    $requestNegative = in_array($requestStatus, ['cancelled', 'disapproved'], true);
    $requestReview = in_array($requestStatus, ['pending', 'for approval'], true);
    $requestFinalClass = $requestNegative ? 'bad' : ($requestStatus === 'rescheduled' ? 'rescheduled' : ($requestReview ? 'waiting' : 'done'));
    $requestReason = $appointment
        ? trim((string) preg_replace('/\R?Patient response:.*$/is', '', (string) $appointment->remarks))
        : '';
@endphp

<style>
  .request-status-panel{
    margin-top:18px;
    padding:16px;
    border:1px solid #cbdcff;
    border-radius:12px;
    background:#f7faff
  }
  .request-status-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;margin-bottom:14px
  }
  .request-status-header h3{
    margin:0;
    color:#405a79;
    font-size:17px;
    font-weight:800
  }
  .request-pill{
    padding:7px 12px;
    border-radius:18px;
    background:#fff2cf;
    color:#805600;
    font-size:12px;
    font-weight:800
  }
  .request-pill.approved,.request-pill.confirmed,.request-pill.done,.request-pill.completed{
    background:#def4e5;
    color:#14743d
  }
  .request-pill.rescheduled{
    background:#f1eaff;
    color:#6440ad}
  .request-pill.cancelled,.request-pill.disapproved{
      background:#ffe5e8;
      color:#b42335
    }
  .request-schedule{
    padding:13px 14px;
    border-radius:10px;
    background:#f4f7fc;
    color:#50617e;
    font-size:12px;
    line-height:1.55
  }
  .request-schedule b{
    color:#0b1f51
  }
  .request-meta{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    margin-top:3px
  }
  .request-reason{
    margin-top:10px;
    padding:10px 12px;
    border:1px solid #ffb4be;
    border-radius:9px;
    background:#fff1f3;
    color:#68454b
  }
  .request-reason b{
    color:#b42335
  }
  .request-process{
    position:relative;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:5px;margin-top:16px
  }
  .request-process:before{
    content:"";position:absolute;
    top:13px;left:16%;
    right:16%;
    height:3px;
    background:#1cad58
  }
  .request-step{
    position:relative;
    text-align:center;
    color:#157d3c;
    font-size:11px;
    font-weight:800
  }
  .request-dot{
    position:relative;
    z-index:1;
    width:27px;
    height:27px;
    margin:0 auto 6px;
    border:2px solid #1cad58;
    border-radius:50%;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#1cad58
  }
  .request-step.waiting{
    color:#946400
  }
  .request-step.waiting .request-dot{
    border-color:#f2ad21;
    color:#f2ad21
  }
  .request-step.bad{
    color:#bd293d
  }
  .request-step.bad .request-dot{
    border-color:#ef5366;
    color:#ef5366
  }
  .request-step.rescheduled{
    color:#6440ad
    }
  .request-step.rescheduled .request-dot{
    border-color:#815cc4;
    color:#815cc4
    }
</style>

@if($appointment)
<div class="request-status-panel">
  <div class="request-status-header">
    <h3><i class="fa fa-tasks" style="color:var(--da-blue)"></i> Request Status</h3>
    <span class="request-pill {{ str_replace(' ', '-', $requestStatus) }}">{{ $requestLabel }}</span>
  </div>
  <div class="request-schedule">
   <div><b>Requested schedule:</b> {{ implode(', ', json_decode($requestPurpose, true) ?? []) ?: 'Dental appointment' }}</div>
    <div class="request-meta">
      <span>
    <i class="fa fa-calendar"></i>
    {{ $appointment->date 
        ? \Carbon\Carbon::parse($appointment->date)->format('M d, Y') 
        : '—' 
    }}
</span>
      <span><i class="fa fa-clock-o"></i> {{ $appointment->time ? \Carbon\Carbon::parse($appointment->time)->format('h:i A') : '—' }}</span>
    </div>
    @if(in_array($requestStatus, ['cancelled', 'disapproved', 'rescheduled'], true))
      <div class="request-reason">
        <b>{{ $requestStatus === 'disapproved' ? 'Reason for disapproval:' : ($requestStatus === 'rescheduled' ? 'Reason for rescheduling:' : 'Reason for cancellation:') }}</b>
        {{ $requestReason ?: 'No reason provided.' }}
      </div>
    @endif
  </div>
  <div class="request-process" aria-label="Appointment request progress">
    <div class="request-step done"><span class="request-dot"><i class="fa fa-check"></i></span>Requested</div>
    <div class="request-step done"><span class="request-dot"><i class="fa fa-check"></i></span>Reviewed</div>
    <div class="request-step {{ $requestFinalClass }}"><span class="request-dot"><i class="fa {{ $requestNegative ? 'fa-times' : ($requestReview ? 'fa-hourglass-half' : 'fa-check') }}"></i></span>{{ $requestLabel }}</div>
  </div>
  @if($requestStatus === 'rescheduled')
    <div class="reschedule-response">
      @if(stripos((string) $appointment->remarks, 'Patient response: Accepted') !== false)
        <b style="margin-bottom:0;color:#157d3c">✓ Attendance confirmed</b>
      @else
        <b>Can you attend the rescheduled appointment?</b>
        <div class="reschedule-response-actions">
          <button type="button" class="reschedule-response-btn accept" data-appointment-id="{{ $appointment->id }}" data-response="accepted">Yes</button>
          <button type="button" class="reschedule-response-btn decline" data-appointment-id="{{ $appointment->id }}" data-response="declined">Cancel</button>
        </div>
        <span class="reschedule-response-message"></span>
      @endif
    </div>
  @endif
</div>
@endif
