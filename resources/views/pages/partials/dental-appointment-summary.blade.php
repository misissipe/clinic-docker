@php
    $summaryPurpose = $appointment->purpose;
    $summaryPurpose = is_array($summaryPurpose) ? implode(', ', $summaryPurpose) : (string) $summaryPurpose;
    $summaryStatus = strtolower((string) $appointment->status);
    $summaryClass = in_array($summaryStatus, ['done','completed','approved','confirmed','rescheduled']) ? 'good' : (in_array($summaryStatus, ['cancelled','disapproved']) ? 'bad' : 'pending');
    $summaryLabel = $summaryStatus === 'rescheduled'
        ? 'Approved (Rescheduled)'
        : $appointment->status;
@endphp
<div class="appointment-summary">
    @php
    $appointmentDate = \Carbon\Carbon::parse($appointment->date);
@endphp

<div class="date-box">
    <span class="month">{{ $appointmentDate->format('M') }}</span>
    <span class="day">{{ $appointmentDate->format('d') }}</span>
    <small>{{ $appointmentDate->format('D') }}</small>
</div>
    <div class="summary-detail">
       <p class="summary-service">{{ implode(', ', json_decode($summaryPurpose, true) ?? []) }}</p>
        <p class="summary-line"><i class="fa fa-clock-o"></i> &nbsp;{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
        <p class="summary-line"><i class="fa fa-map-marker"></i> &nbsp;{{ $clinicLocation }}</p>
        <span class="badge-status {{ $summaryClass }}">{{ $summaryLabel }}</span>
    </div>
</div>
