@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Schedule')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
 table,td,tr{
 border: 1px solid rgb(226, 222, 222);
 border-collapse: collapse;
 padding: 1px;
 text-align: center;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  input {
  outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  </style>
  <style>
  textarea  {
    outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  .ph-card-header
  {
      background-color: #3a76c5;
  }
  .cell-border{
    border-color: rgb(138, 138, 138)
  }

  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }

  .inline-cursor:hover {
    font-size: 16px; 
    color: #000000;
    cursor: pointer;
  }
  .pending-status {
    color: rgb(99, 175, 211);
    text-shadow:  5px rgba(113, 207, 238, 0.5);
  }

  .approved-status {
    color:  rgb(99, 211, 108); 
    text-shadow:  5px rgba(113, 238, 121, 0.5);
  }
  .disapproved-status {
    color: rgb(211, 99, 99); 
    text-shadow:  5px rgba(238, 113, 113, 0.5);
  }
  .rescheduled-status {
    color: rgb(206, 187, 48);
    text-shadow:  5px rgba(238, 113, 113, 0.5);
  }

  .schedule-dashboard{margin-bottom:24px}
  .schedule-hero{display:flex;justify-content:space-between;gap:20px;align-items:center;margin-bottom:18px}
  .schedule-hero h2{color:#10275b;font-size:26px;font-weight:800;margin:0 0 5px}
  .schedule-hero p{color:#687694;margin:0}
  .schedule-date{background:#edf4ff;color:#0758e8;border-radius:10px;padding:10px 14px;font-weight:700;white-space:nowrap}
  .schedule-stats{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:18px}
  .schedule-stat{background:#fff;border:1px solid #dfe7f3;border-radius:13px;padding:17px;box-shadow:0 5px 18px rgba(18,48,96,.05)}
  .schedule-stat span{display:block;color:#6a7894;font-size:12px;font-weight:700;text-transform:uppercase}
  .schedule-stat b{display:block;color:#10275b;font-size:27px;line-height:1.2;margin-top:6px}
  .schedule-stat.today{border-left:4px solid #0758e8}.schedule-stat.upcoming{border-left:4px solid #7258d6}.schedule-stat.for-approval{border-left:4px solid #f07800;background:#fff8ed}.schedule-stat.pending{border-left:4px solid #e5a000}.schedule-stat.approved{border-left:4px solid #1a9b55}.schedule-stat.rescheduled{border-left:4px solid #9a67d8}
  .schedule-columns{display:grid;grid-template-columns:1fr 1fr;gap:18px}
  .schedule-panel{background:#fff;border:1px solid #dfe7f3;border-radius:14px;overflow:hidden;box-shadow:0 5px 18px rgba(18,48,96,.05)}
  .schedule-panel-head{display:flex;justify-content:space-between;align-items:center;padding:16px 18px;border-bottom:1px solid #e5ebf4}
  .schedule-panel-head h3{color:#10275b;font-size:17px;font-weight:800;margin:0}.schedule-panel-head span{color:#6a7894;font-size:12px}
  .schedule-list{padding:3px 18px}
  .schedule-row{display:grid;grid-template-columns:74px minmax(0,1fr) auto;gap:13px;align-items:center;padding:13px 0;border-bottom:1px solid #edf1f7}
  .schedule-row:last-child{border-bottom:0}.schedule-when{color:#0758e8;font-size:12px;font-weight:800}.schedule-when small{display:block;color:#6a7894;font-weight:600;margin-top:3px}
  .schedule-patient{color:#10275b;font-weight:750;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.schedule-service{color:#6a7894;font-size:12px;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .schedule-pill{border-radius:20px;padding:5px 9px;font-size:14px;font-weight:800}.schedule-pill.for-approval{background:#ffe0b2;color:#9a4300;border:1px solid #ffbd66}.schedule-pill.pending{background:#fff2cf;color:#865a00}.schedule-pill.approved{background:#e0f5e8;color:#14743d}.schedule-pill.rescheduled{background:#f3edff;color:#6542b5}.schedule-pill.disapproved,.schedule-pill.cancelled{background:#ffe5e8;color:#b42335}.schedule-pill.done,.schedule-pill.completed{background:#e5eefc;color:#315f9e}
  .schedule-empty{color:#78859d;text-align:center;padding:30px 15px}
  @media(max-width:900px){.schedule-stats{grid-template-columns:repeat(2,1fr)}.schedule-columns{grid-template-columns:1fr}}
  @media(max-width:560px){.schedule-hero{align-items:flex-start;flex-direction:column}.schedule-stats{grid-template-columns:1fr 1fr}.schedule-row{grid-template-columns:64px minmax(0,1fr)}.schedule-pill{grid-column:2;justify-self:start}}

</style>
@endsection
{{-- page-styles --}}

@section('content')
@php
  $formatPurpose = function ($purpose) {
      if (is_array($purpose)) {
          return implode(', ', $purpose);
      }

      if ($purpose === null || trim((string) $purpose) === '') {
          return '—';
      }

      $decoded = json_decode((string) $purpose, true);
      return is_array($decoded) ? implode(', ', $decoded) : (string) $purpose;
  };
  $dashboardStatusClass = function ($status) {
      $value = strtolower(trim((string) $status));
      if ($value === 'for approval') return 'for-approval';
      return in_array($value, ['approved', 'rescheduled', 'pending', 'disapproved', 'cancelled', 'done', 'completed'], true)
          ? $value
          : 'pending';
  };
@endphp
<section class="schedule-dashboard">
  <div class="schedule-hero">
    <div><h2>Dental Schedule</h2>
      <p>Quick overview of today’s clinic schedule and upcoming appointments.</p></div>
    <div class="schedule-date"><i class="fa fa-calendar"></i> {{ now()->format('l, F d, Y') }}</div>
  </div>
  <div class="schedule-stats">
    <div class="schedule-stat today"><span>Today</span><b>{{ $schedToday }}</b></div>
    <div class="schedule-stat upcoming"><span>Upcoming</span><b>{{ $upcomingCount }}</b></div>
    <div class="schedule-stat pending"><span>Pending</span><b>{{ $pendingCount }}</b></div>
    <div class="schedule-stat approved"><span>Approved</span><b>{{ $approvedCount }}</b></div>
    <div class="schedule-stat rescheduled"><span>Rescheduled</span><b>{{ $rescheduledCount }}</b></div>
  </div>
  <div class="schedule-columns">
    <div class="schedule-panel">
      <div class="schedule-panel-head"><h3><i class="fa fa-clock-o"></i> Today’s Schedule</h3><span>{{ $viewToday->count() }} appointment(s)</span></div>
      <div class="schedule-list">
        @forelse($viewToday as $data)
          <div class="schedule-row">
            <div class="schedule-when">{{ date('h:i A', strtotime($data->time)) }}<small>Today</small></div>
            <div>
              <div class="schedule-patient">{{ trim($data->firstname.' '.$data->middlename.' '.$data->lastname) }}</div>
            <div class="schedule-service">{{ $formatPurpose($data->purpose) }}</div></div>
            <span class="schedule-pill {{ $dashboardStatusClass($data->status) }}">{{ $data->status }}</span>
          </div>
        @empty
          <div class="schedule-empty"><i class="fa fa-calendar-check-o"></i><br>No appointments scheduled today.</div>
        @endforelse
      </div>
    </div>
    <div class="schedule-panel">
      <div class="schedule-panel-head"><h3><i class="fa fa-calendar-plus-o"></i> Upcoming Schedule</h3>
        <span>Next {{ $upcomingSchedules->count() }}</span>
      </div>
      <div class="schedule-list">
        @forelse($upcomingSchedules as $data)
          <div class="schedule-row">
            <div class="schedule-when">{{ date('M d', strtotime($data->date)) }}<small>{{ date('h:i A', strtotime($data->time)) }}</small></div>
            <div>
              <div class="schedule-patient">{{ trim($data->firstname.' '.$data->middlename.' '.$data->lastname) }}</div>
              <div class="schedule-service">{{ $formatPurpose($data->purpose) }}</div>
            </div>
            <span class="schedule-pill {{ $dashboardStatusClass($data->status) }}">{{ $data->status }}</span>
          </div>
        @empty
          <div class="schedule-empty"><i class="fa fa-calendar-o"></i><br>No upcoming appointments.</div>
        @endforelse
      </div>
    </div>
  </div>
</section>
@endsection
