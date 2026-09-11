@extends('layouts.contentLayoutMaster')

@section('title', !empty($historyOnly) ? 'Appointment History' : 'My Dental Appointments')

@section('content')
<style>
    .my-appts{
        max-width:1050px;
        margin:auto;
        padding:24px
    }
    .my-card{
        background:#fff;
        border:1px solid #dfe7f3;
        border-radius:16px;
        padding:25px
    }
    .my-head{
        display:flex;
        justify-content:space-between;
        gap:15px;align-items:center;
        margin-bottom:22px
    }
    .my-head h1{
        margin:0;
        color:#0b1f51
    }
    .my-actions{
        display:flex;
        align-items:center;
        gap:10px
    }
    .my-link,.my-back{
        border-radius:8px;
        padding:11px 17px;
        font-weight:700;
        text-decoration:none
    }
    .my-link{
        background:#0758e8;
        color:#fff!important
    }
    .my-back{
        background:#fff;
        color:#0758e8!important;
        border:1px solid #0758e8
    }
    .appts-table-wrap{
        overflow-x:auto
    }
    .appts-table{
        width:100%;
        border-collapse:collapse
    }
    .appts-table th,.appts-table td{
        text-align:left;
        padding:14px;
        border-bottom:1px solid #e3e9f2
    }
    .appts-table th{
        color:#64708c;
        font-size:12px;
        text-transform:uppercase
    }
    .pill{
        display:inline-block;
        padding:5px 9px;
        border-radius:8px;
        font-size:12px;
        font-weight:700
    }
    .pill.pending{
        background:#fff2cf;
        color:#805600
    }
    .pill.for-approval{
        background:#ffe0b2;
        color:#9a4300
    }
    .pill.approved,.pill.confirmed{
        background:#e0f5e8;
        color:#14743d
    }
    .pill.rescheduled{
        background:#f1eaff;
        color:#6440ad
    }
    .pill.cancelled,.pill.disapproved{
        background:#ffe5e8;
        color:#b42335
    }
    .pill.done,.pill.completed{
        background:#e5eefc;
        color:#315f9e
    }
    .status-reason{
        max-width:220px;
        margin-top:6px;
        color:#6a7894;
        font-size:11px;
        line-height:1.35;
        word-break:break-word
    }
    .status-reason b{
        color:#45546f
    }
    .reschedule-date{
        color:#6440ad;
        font-weight:700;
        white-space:nowrap
    }

    @media(max-width:700px){
        .my-appts{padding:10px}
        .my-head{align-items:flex-start;flex-direction:column}
        .my-actions{width:100%;flex-wrap:wrap}
        .appts-table,.appts-table tbody,.appts-table tr,.appts-table td{display:block}
        .appts-table thead{display:none}
        .appts-table tr{padding:12px 0;border-bottom:1px solid #e3e9f2}
        .appts-table td{border:0;padding:4px 0}
        .appts-table td:before{content:attr(data-label) ": ";font-weight:700}
    }
</style>

<div class="my-appts">
    <div class="my-card">
        <div class="my-head">
            <div>
                <h1>{{ !empty($historyOnly) ? 'Appointment History' : 'My Dental Appointments' }}</h1>
                <p style="color:#64708c;margin:5px 0 0">
                    {{ !empty($historyOnly) ? 'View all of your previous dental appointments.' : 'View your upcoming and previous clinic visits.' }}
                </p>
            </div>
            <div class="my-actions">
                <a class="my-back" href="{{ route('dental.appointment.create') }}"><i class="fa fa-arrow-left"></i> Back</a>
                <a class="my-link" href="{{ route('dental.appointment.create') }}">Book Appointment</a>
            </div>
        </div>

        <div class="appts-table-wrap">
        <table class="appts-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Service</th>
                    <th>New Reschedule Date &amp; Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    @php
                        $purpose = is_array($appointment->purpose) ? implode(', ', $appointment->purpose) : (string) $appointment->purpose;
                        $statusClass = str_replace(' ', '-', strtolower((string) $appointment->status));
                        $hasRescheduledSchedule = $statusClass === 'rescheduled'
                            || $appointment->original_date
                            || $appointment->original_time;
                    @endphp
                    <tr>
                        <td data-label="Date">{{ ($appointment->original_date ?: $appointment->date) ? ($appointment->original_date ?: $appointment->date)->format('M d, Y') : '—' }}</td>
                        <td data-label="Time">{{ ($appointment->original_time ?: $appointment->time) ? \Carbon\Carbon::parse($appointment->original_time ?: $appointment->time)->format('h:i A') : '—' }}</td>
                        <td data-label="Service">{{ $purpose ?: '—' }}</td>
                        <td data-label="New Reschedule Date & Time">
                            @if($hasRescheduledSchedule)
                                <span class="reschedule-date">
                                    {{ $appointment->date ? $appointment->date->format('M d, Y') : '—' }}<br>
                                    {{ $appointment->time ? \Carbon\Carbon::parse($appointment->time)->format('h:i A') : '—' }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td data-label="Status">
                            <span class="pill {{ $statusClass }}">{{ $appointment->status ?: 'Unknown' }}</span>
                            @if(in_array($statusClass, ['disapproved', 'rescheduled', 'cancelled'], true))
                                <div class="status-reason"><b>Reason:</b> {{ $appointment->remarks ?: 'No reason provided.' }}</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:#64708c;padding:35px">No dental appointments found.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div style="margin-top:18px">{{ $appointments->links() }}</div>
    </div>
</div>
@endsection
