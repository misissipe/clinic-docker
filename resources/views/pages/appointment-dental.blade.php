@extends('layouts.contentLayoutMaster')
@section('title', 'Book a Dental Appointment')

@section('vendor-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')
@php
    $serviceDetails = [
        'Consultation' => ['Dental check-up and consultation', 'fa-stethoscope', 'blue'],
        'Oral Restoration' => ['Cavity filling and oral restoration', 'fa-shield', 'teal'],
        'Oral Prophylaxis' => ['Professional dental cleaning', 'fa-star', 'gold'],
        'Tooth Extraction' => ['Tooth extraction and evaluation', 'fa-heart-o', 'pink'],
    ];

    $clinicLocation = 'SLSU Clinic, Student Center';
    $oldServices = old('service', []);
    $fullName = $patientDetails['full_name'] ?? trim(collect([
        optional($user)->firstname,
        optional($user)->middlename,
        optional($user)->lastname,
    ])->filter()->implode(' '));
    if (!$fullName) $fullName = optional($user)->name ?? '';
    $patientId = $patientDetails['patient_id'] ?? optional($user)->patientId
        ?? optional($user)->StudentNo
  
        ?? optional($user)->AgencyNumber
        ?? session('patientId')
        ?? '';
    $purposeText = function ($appointment) {
        if (!$appointment) return 'Dental service';
        $purpose = $appointment->purpose;
        return is_array($purpose) ? implode(', ', $purpose) : (string) $purpose;
    };
    $cleanNotes = function ($remarks) {
        $lines = preg_split('/\R/', (string) $remarks);
        $lines = array_filter($lines, function ($line) {
            return stripos(trim($line), 'Course/Department:') !== 0;
        });
        return trim(implode("\n", $lines));
    };
    $statusClass = function ($status) {
        $value = strtolower((string) $status);
        if ($value === 'for approval') return 'for-approval';
        if (in_array($value, ['done', 'completed', 'approved', 'confirmed'])) return 'good';
        if (in_array($value, ['cancelled', 'disapproved'])) return 'bad';
        return 'pending';
    };
@endphp

<style>
    :root{
      --da-blue:#0758e8;
      --da-dark:#0b1f51;
      --da-muted:#65718f;
      --da-line:#dce5f3;
      --da-bg:#f5f8fd;
      --da-soft:#eef4ff;
      --da-green:#119447
    }

    body{background:var(--da-bg)}

    .da-page{
      max-width:1540px;
      margin:0 auto;
      padding:24px;
      color:var(--da-dark);
      font-family:Inter,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif
    }
    
    .da-grid{
      display:grid;
      grid-template-columns:minmax(0,1.75fr) minmax(350px,.85fr);
      gap:24px;align-items:start
    }

    .da-panel{
      background:#fff;
      border:1px solid #e2e9f5;
      border-radius:17px;box-shadow:0 10px 32px rgba(20,55,115,.055)
    }

    .da-booking{
      padding:28px
    }

    .da-title{
      font-size:27px;
      font-weight:750;
      margin:0 0 6px
    }

    .da-subtitle{
      color:var(--da-muted);
      font-size:16px;
      margin:0
    }

    .da-progress{
      display:grid;
      grid-template-columns:repeat(4,1fr);
      margin:30px 0 32px
    }

    .da-progress-item{
      text-align:center;
      position:relative;
      min-width:0
    }

    .da-progress-item:not(:last-child):after{content:"";height:2px;background:var(--da-line);position:absolute;top:19px;left:62%;width:76%}
    .da-progress-item.done:not(:last-child):after{background:#a8c6ff}

    .da-dot{
      position:relative;
      z-index:1;
      width:39px;
      height:39px;
      border-radius:50%;
      display:grid;
      place-items:center;
      margin:auto;
      background:#edf1f7;
      color:#586783;
      font-weight:700;
      font-size:16px
    }

    .active 
    .da-dot,
    .done 
    .da-dot{
      background:var(--da-blue);
      color:#fff
    }

    .da-step-name{
      font-weight:700;
      margin-top:10px;
      font-size:14px
    }

    .da-step-note{
      color:var(--da-muted);
      font-size:12px;
      margin-top:3px;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis
    }

    .da-step{
      display:none
    }
    .da-step.active{
      display:block
    }
    .da-card{
      border:1px solid var(--da-line);
      border-radius:14px;
      padding:22px
    }
    .da-heading{
      font-size:20px;
      font-weight:750;
      margin:0 0 5px
    }
    .da-help{
      color:var(--da-muted);
      margin:0 0 20px
    }
    .service-grid{
      display:grid;
      grid-template-columns:repeat(4,minmax(0,1fr));
      gap:10px
    }
    .service-option{
      margin:0;
      cursor:pointer;
      position:relative
    }
    .service-option input{
      position:absolute;
      opacity:0
    }

    .service-tile{
      display:block;
      height:100%;
      min-height:122px;
      border:1px solid var(--da-line);
      border-radius:11px;
      padding:12px;
      transition:.18s;
      background:#fff
    }

    .service-option:hover 

    .service-tile{
      border-color:#9bbcff;
      transform:translateY(-1px);
      box-shadow:0 6px 18px rgba(7,88,232,.07)
    }

    .service-option input:checked+.service-tile{
      border:2px solid var(--da-blue);background:linear-gradient(135deg,#f2f7ff,#fff);
      padding:11px;
      box-shadow:0 0 0 2px rgba(7,88,232,.05)
    }

    .service-icon{
      width:36px;
      height:36px;
      border-radius:10px;
      display:grid;
      place-items:center;
      margin-bottom:8px;
      font-size:16px}

    .service-icon.blue{
      background:#e1ecff;
      color:#0758e8
    }

    .service-icon.teal{
      background:#ddf8f2;
      color:#13ac96
    }
    .service-icon.pink{
      background:#fde5ef;
      color:#ee3d79
    }

    .service-icon.gold{
      background:#fff3d5;
      color:#e9a300
    }
    .service-icon.violet{
      background:#f0e6ff;
      color:#7427df
    }

    .service-icon.slate{
      background:#edf2f8;
      color:#49617d
    }

    .service-name{
      font-weight:750;
      display:block;
      margin-bottom:4px;
      font-size:12px;
      line-height:1.3
    }

    .service-description{
      font-size:11px;
      line-height:1.35;
      color:var(--da-muted)
    }

    .da-schedule{display:grid;
      grid-template-columns:minmax(230px,.85fr) minmax(300px,1.15fr);
      gap:24px
    }

    .date-card{
      border:1px solid var(--da-line);
      border-radius:12px;padding:22px;
      background:#fbfdff
    }

    .date-card input{
      width:100%;
      min-height:48px;
      border:1px solid var(--da-line);
      border-radius:9px;padding:10px;
      color:var(--da-dark);
      background:#fff
    }

    .date-tip{
      font-size:13px;
      color:var(--da-muted);
      margin:12px 0 0
    }

    .slot-title{
      font-weight:750;
      margin:5px 0 14px
    }
    .time-grid{
      display:grid;
      grid-template-columns:repeat(3,1fr);
      gap:10px
    }

    .time-button{
      min-height:45px;
      border:1px solid #d4deee;
      border-radius:9px;
      background:#fff;
      color:var(--da-dark);
      cursor:pointer
    }

    .time-button:hover,.time-button.selected{
      border-color:var(--da-blue);
      background:var(--da-blue);
      color:#fff
    }

    .empty-times{
      grid-column:1/-1;
      border:1px dashed var(--da-line);
      border-radius:10px;
      padding:28px;
      text-align:center;
      color:var(--da-muted)
    }

    .form-grid{
      display:grid;
      grid-template-columns:repeat(2,1fr);
      gap:17px 20px
    }

    .field.full{
      grid-column:1/-1
    }
    .field label{
      display:block;
      font-weight:700;
      margin-bottom:7px
    }

    .field input,.field select,.field textarea{
      width:100%;
      border:1px solid #d6e0ef;
      border-radius:9px;
      padding:11px 13px;
      color:var(--da-dark);
      background:#fff;
      outline:none
    }

    .field input,.field select{
      height:48px
    }

    .field textarea{
      min-height:96px;
      resize:vertical
    }

    .field input:focus,.field select:focus,.field textarea:focus{
      border-color:var(--da-blue);
      box-shadow:0 0 0 3px rgba(7,88,232,.1)
    }

    .count{
      text-align:right;
      color:var(--da-muted);
      font-size:12px;
      margin-top:-22px;
      margin-right:9px;
      position:relative;
      pointer-events:none
    }

    .required{
      color:#d62d3f
    }
    .info-strip,.success-strip,.warning-strip{
      padding:14px 16px;
      border-radius:10px;
      margin-top:18px;
      display:flex;
      gap:12px;
      align-items:flex-start
    }

    .info-strip{
      background:#eef4ff;
      color:#174286
    }

    .success-strip{
      background:#eaf8ed;
      color:#176c34
    }

    .warning-strip{
      background:#fff7e4;
      color:#785114
    }

    .review-box{
      background:#f8fbff;
      border:1px solid #cbdcff;
      border-radius:12px;
      padding:18px
    }

    .review-title{
      color:var(--da-blue);
      font-weight:750;
      font-size:17px;
      margin-bottom:8px
    }

    .review-row{
      display:grid;
      grid-template-columns:42px 135px 1fr;
      align-items:center;
      gap:10px;padding:13px 0;
      border-bottom:1px solid var(--da-line)
    }

    .review-row:last-child{
      border:0
    }
    .review-symbol{
      width:36px;
      height:36px;
      background:#eaf1ff;
      color:var(--da-blue);
      border-radius:50%;
      display:grid;
      place-items:center
    }

    .review-label{
      color:#53617e
    }
    .review-value{
      font-weight:700;
      word-break:break-word
    }

    .button-row{
      display:flex;
      justify-content:space-between;
      gap:12px;margin-top:22px
    }

    .btn-da{
      min-height:46px;
      padding:11px 22px;
      border-radius:8px;
      border:1px solid var(--da-blue);
      font-weight:700;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:9px;cursor:pointer;
      text-decoration:none
    }

    .btn-da.primary{
      background:var(--da-blue);
      color:#fff !important;
      -webkit-text-fill-color:#fff
    }

    .btn-da.primary i{
      color:#fff
    }

    .btn-da.primary:hover{
      background:#064bc5;color:#fff
    }

    .btn-da.outline{
      background:#fff;color:var(--da-blue)
    }

    .btn-da:disabled{
      opacity:.6;cursor:not-allowed
    }

    button.btn-da.primary:disabled{
      opacity:1 !important;
      background:#94a3b8 !important;
      border-color:#94a3b8 !important;
      color:#fff !important;
      -webkit-text-fill-color:#fff !important;
      cursor:not-allowed !important
    }

    button.btn-da.primary:disabled i{
      color:#fff !important;
      -webkit-text-fill-color:#fff !important
    }

    .side-panel{
      padding:22px;margin-bottom:20px
    }

    .side-title{
      font-weight:750;
      font-size:18px;
      margin:0 0 15px;
      display:flex;
      justify-content:space-between;
      gap:12px
    }

    .side-title a{
      font-size:13px;
      color:var(--da-blue)
    }

    .appointment-summary{
      display:flex;
      flex-wrap:wrap;
      gap:10px 16px;
      align-items:center;
      border:1px solid var(--da-line);
      border-radius:12px;
      padding:12px
    }

    .date-box{
      width:84px;
      flex:0 0 84px;
      text-align:center;
      padding:10px 7px;
      border-radius:12px;
      background:var(--da-soft)
    }

    .date-box .month{
      color:var(--da-blue);
      font-weight:750
    }

    .date-box .day{
      font-size:31px;
      line-height:1.05;
      font-weight:800;
      display:block
    }
    .summary-detail{
      min-width:0;
      flex:1
    }

    .summary-service{
      font-weight:750;
      margin:0 0 8px
    }

    .summary-line{
      font-size:13px;
      color:#52617e;
      margin:5px 0
    }

    .badge-status{
      display:inline-block;
      border-radius:8px;
      padding:5px 10px;
      font-weight:700;
      font-size:11px
    }

    .badge-status.good{
      background:#e2f5e5;
      color:#137832
    }

    .badge-status.bad{
      background:#ffe5e8;
      color:#c92a3d
    }

    .badge-status.pending{
      background:#fff2cf;
      color:#8b5c00
    }

    .badge-status.for-approval{
      background:#ffe0b2;
      color:#9a4300;
      border:1px solid #ffbd66
    }

    .reschedule-response{
      flex:0 0 100%;
      width:100%;
      margin-top:10px;
      padding:9px 10px;
      border:1px solid #d8c5ff;
      border-radius:9px;
      background:#fff
    }

    .reschedule-response b{
      display:block;
      color:#51358e;
      font-size:12px;
      margin-bottom:7px
    }

    .reschedule-response-actions{
      display:flex;
      flex-wrap:wrap;
      gap:6px
    }

    .reschedule-response-btn{
      border:0;
      border-radius:7px;
      padding:6px 9px;
      font-size:10px;
      font-weight:800;
      cursor:pointer
    }

    .reschedule-response-btn.accept{
      background:#22a653;
      color:#fff
    }

    .reschedule-response-btn.decline{
      background:#fff;
      color:#b42335;
      border:1px solid #efadb5
    }

    .reschedule-response-btn:disabled{
      opacity:.6;
      cursor:wait
    }

    .reschedule-response-message{
      display:none;
      margin-top:7px;
      color:#52617e;
      font-size:11px
    }
    
    .history-item{
      display:grid;
      grid-template-columns:55px 1fr auto;
      gap:12px;align-items:center;
      padding:11px 0;
      border-bottom:1px solid var(--da-line)
    }

    .history-item:last-of-type{
      border-bottom:0
    }
    .history-date-box{
      text-align:center;
      background:#f0f5ff;
      border-radius:9px;
      padding:7px 4px;
      color:var(--da-blue);
      font-size:10px;
      font-weight:700
    }

    .history-date-box b{
      display:block;
      font-size:20px;
      color:var(--da-dark)
    }

    .history-name{
      font-weight:700;
      font-size:13px
    }

    .history-meta{
      color:var(--da-muted);
      font-size:11px;
      margin-top:4px
    }

    .history-reason{
      color:#b42335;
      font-size:11px;
      line-height:1.35;
      margin-top:5px;
      word-break:break-word
    }

    .guideline-grid{
      display:grid;
      grid-template-columns:repeat(4,1fr);
      gap:18px;
      margin-top:clamp(70px,10vh,120px)
    }

    .guide{
      padding:16px 18px;
      display:flex;
      gap:13px;
      align-items:center
    }

    .guide i{
      font-size:25px;
      color:var(--da-blue)
    }

    .guide b{
      display:block
    }

    .guide span{
      font-size:12px;
      color:var(--da-muted)
    }

    .mini-process{
      display:flex;
      flex-wrap:wrap;
      align-items:flex-start;
      width:100%;
      margin-top:12px;
      padding:10px 9px 9px;
      border:1px solid #b9d0ff;
      border-radius:10px;
      background:#f2f7ff;
      box-shadow:0 3px 10px rgba(7,88,232,.08)
    }

    .mini-process-title{
      flex:0 0 100%;
      margin:0 0 6px;
      color:#173b78;
      font-size:11px;
      font-weight:800;
      text-transform:uppercase;
      letter-spacing:.35px
    }

    .mini-process-step{
      position:relative;
      flex:1;text-align:center;
      color:#7b879d;
      font-size:11px;
      font-weight:800;
      padding-top:25px
    }

    .mini-process-step:before{
      content:"";
      position:absolute;
      top:2px;left:50%;
      width:18px;
      height:18px;
      border-radius:50%;
      transform:translateX(-50%);
      display:grid;
      place-items:center;
      background:#d7dfeb;
      border:3px solid #fff;
      box-shadow:0 0 0 1px #cbd5e4;
      color:#fff;
      font-size:10px;
      line-height:18px;
      z-index:2
    }

    .mini-process-step:not(:last-of-type):after{
      content:"";
      position:absolute;
      top:11px;
      left:50%;
      width:100%;
      height:3px;
      background:#d7dfeb;
      z-index:1
    }

    .mini-process-step.done{
      color:#157d3c
    }
    .mini-process-step.done:before{
      content:"✓";
      background:#22a653;
      box-shadow:0 0 0 1px #22a653
    }
    .mini-process-step.done:not(:last-of-type):after{
      background:#22a653
    }

    .mini-process-step.current{
      color:#8b5c00
    }
    .mini-process-step.current:before{
      content:"•";
      background:#f0b429;
      box-shadow:0 0 0 1px #f0b429;
      font-size:16px
    }

    .mini-process-step.bad{
      color:#b42335
    }
    .mini-process-step.bad:before{
      content:"×";
      background:#d94352;
      box-shadow:0 0 0 1px #d94352;
      color:#fff;
      font-size:14px
    }

    .mini-process-step.rescheduled{
      color:#6440ad
    }
    .mini-process-step.rescheduled:before{
      content:"↻";
      background:#7953c6;
      box-shadow:0 0 0 1px #7953c6;
      color:#fff;
      font-size:13px
    }

    .progress-status-reason{
      flex:0 0 100%;
      width:100%;
      margin-top:10px;
      padding:8px 10px;
      border-radius:8px;
      background:#fff;
      color:#52617e;
      font-size:11px;
      line-height:1.45
    }

    .progress-status-reason b{
      color:#173b78
    }

    .progress-status-reason.disapproved{
      border:1px solid #ffc9ce;
      background:#fff7f8
    }
    .progress-status-reason.disapproved b{
      color:#b42335
    }
    .progress-status-reason.rescheduled{
      border:1px solid #d8c5ff;
      background:#faf7ff
    }
    .progress-status-reason.rescheduled b{
      color:#6440ad
    }

    .confirmation-layout{
      display:grid;
      grid-template-columns:1.2fr .8fr;
      gap:24px
    }

    .confirmation-main{
      padding:38px
    }

    .confirmation-hero{
      text-align:center
    }

    .confirmation-hero h1{
      color:var(--da-green);
      font-size:29px
    }

    .checkmark{
      width:118px;
      height:118px;
      margin:25px auto;
      border-radius:50%;
      background:#dcf7e5;
      color:var(--da-green);
      display:grid;
      place-items:center;
      font-size:61px
    }

    .confirmation-copy{
      color:var(--da-muted);
      font-size:16px
    }

    .confirmation-detail{
      margin-top:28px;
      border:1px solid var(--da-line);
      border-radius:12px;padding:18px
    }

    .confirmation-actions{
      display:grid;
      grid-template-columns:1fr 1.3fr;
      gap:12px;
      margin-top:22px
    }

    .errors{
      background:#fff0f1;
      border:1px solid #ffc9ce;
      color:#a51d2a;
      padding:14px 17px;
      border-radius:10px;
      margin:18px 0
    }

    .leave-announcement{
      background:#fff7e4;
      border:1px solid #f1d48b;
      color:#714b00;
      border-radius:11px;
      padding:14px 16px;
      margin:18px 0;
      display:flex;
      gap:12px;
      align-items:flex-start
    }
    .leave-announcement strong{
      display:block;
      margin-bottom:3px}
      
    .leave-announcement[hidden]{display:none}

    .errors ul{
      margin:7px 0 0;
      padding-left:20px
    }

    .empty-copy{
      color:var(--da-muted);
      font-size:13px
    }
    .sr-only{
      position:absolute;
      width:1px;
      height:1px;
      padding:0;
      margin:-1px;
      overflow:hidden;
      clip:rect(0,0,0,0);
      white-space:nowrap;
      border:0
    }
    
    @media(max-width:1100px)
    {
      .da-grid,.confirmation-layout{
        grid-template-columns:1fr
      }
      .guideline-grid{
        grid-template-columns:repeat(2,1fr)
      }
    }
    @media(max-width:800px)
      {
        .service-grid{
          grid-template-columns:repeat(2,1fr)
        }
      }
    @media(max-width:700px)
      {
        .da-page{
          padding:12px
        }

        .da-booking,
        .confirmation-main{
          padding:17px
        }

        .da-progress{
          overflow-x:auto;
          grid-template-columns:repeat(4,minmax(115px,1fr))
        }

        .da-schedule,
        .form-grid{
          grid-template-columns:1fr
        }
        .field.full{
          grid-column:auto
        }
        .service-grid{
          grid-template-columns:1fr
        }
        .time-grid{
          grid-template-columns:repeat(2,1fr)
        }
        .review-row{
          grid-template-columns:40px 1fr
        }
        .review-label{
          display:none
        }
        .button-row,
        .confirmation-actions{
          grid-template-columns:1fr;
          display:grid
        }
        .btn-da{
          width:100%
        }
        .guideline-grid{
          grid-template-columns:1fr;
          margin-top:35px
        }
        }
</style>
<section>
<div class="da-page">
@if(session('appointment_confirmed') && $confirmedAppointment)
  <div class="confirmation-layout">
    <main class="da-panel confirmation-main">
      <div class="confirmation-hero">
        <h1>Appointment Request Submitted!</h1>
        <p class="confirmation-copy">Your dental appointment has been successfully booked.</p>
          <div class="checkmark"><i class="fa fa-check"></i></div>
            <h3>We look forward to seeing you!</h3>
            <p class="confirmation-copy">Your request is pending clinic approval.</p>
          </div>
          <div class="confirmation-detail">
            <div class="review-title"><i class="fa fa-medkit"></i> &nbsp; Appointment Details</div>
              <div class="review-row">
                <span class="review-symbol"><i class="fa fa-medkit"></i></span>
                <span class="review-label">Service</span><span class="review-value">{{ $purposeText($confirmedAppointment) }}</span>
              </div>
              <div class="review-row">
                <span class="review-symbol"><i class="fa fa-calendar"></i></span>
                <span class="review-label">Date & Time</span>
                <span class="review-value">{{ $confirmedAppointment->date->format('l, F d, Y') }}<br>
                  <span style="color:var(--da-blue)">{{ \Carbon\Carbon::parse($confirmedAppointment->time)->format('h:i A') }}</span>
                </span>
              </div>
              <div class="review-row">
                <span class="review-symbol"><i class="fa fa-map-marker"></i></span>
                <span class="review-label">Location</span>
                <span class="review-value">{{ $clinicLocation }}</span>
              </div>
              <div class="review-row">
                <span class="review-symbol"><i class="fa fa-user"></i></span>
                <span class="review-label">Patient</span>
                <span class="review-value">{{ trim($confirmedAppointment->firstname.' '.$confirmedAppointment->middlename.' '.$confirmedAppointment->lastname) }} ({{ $confirmedAppointment->patientId }})</span>
              </div>
              @if($cleanNotes($confirmedAppointment->remarks))
              <div class="review-row">
                <span class="review-symbol"><i class="fa fa-file-text-o"></i></span>
                <span class="review-label">Notes</span>
                <span class="review-value" style="white-space:pre-line">{{ $cleanNotes($confirmedAppointment->remarks) }}</span>
              </div>
              @endif
            </div>
            <div class="info-strip">
              <i class="fa fa-info-circle"></i>
              <div>
                <b>What’s next?</b>
                <br>Please arrive at least 10-15 minutes early and bring your school or employee ID.
              </div>
            </div>
            <div class="confirmation-actions">
              <a class="btn-da outline" href="{{ route('dental.appointment.create') }}"><i class="fa fa-plus"></i> Book Another</a>
              {{-- <a class="btn-da primary" href="{{ route('dental.appointment.index') }}">View My Appointments</a> --}}
              <a class="btn-da primary" href="{{ route('dental.appointment.create') }}">Back</a>
            </div>
        </main>
        <aside>
          <div class="da-panel side-panel">
            <h3 class="side-title">Appointment Summary</h3>
            @include('pages.partials.dental-appointment-summary', ['appointment' => $confirmedAppointment])
            <div class="success-strip"><i class="fa fa-check-circle"></i><div>
              <b>Request received!</b>
              <br>The clinic will review and confirm your schedule.</div>
            </div>
          </div>
          <div class="da-panel side-panel">
            <h3 class="side-title"><span>Before Your Visit</span></h3>
            <ul style="padding-left:20px;color:var(--da-muted);line-height:2.1">
              <li>Brush and floss your teeth.</li>
              <li>Avoid heavy meals one hour before.</li>
              <li>Bring your school/employee ID.</li>
              <li>Tell us about medical conditions.</li></ul>
            </div>
        </aside>
    </div>
    <div class="warning-strip" style="margin-top:22px"><i class="fa fa-info-circle"></i> You may cancel or reschedule your appointment at least 24 hours in advance.</div>
  @else
    <div class="da-grid">
      <main class="da-panel da-booking">
        <h1 class="da-title">Book an Appointment</h1>
        <p class="da-subtitle">Schedule your visit with SLSU clinic.</p>
        @if($leaveAnnouncements->isNotEmpty())
        <div class="leave-announcement" id="generalLeaveAnnouncement">
          <i class="fa fa-bullhorn"></i>
          <div><strong>Clinic schedule announcement</strong>
            @foreach($leaveAnnouncements as $leave)
              <div>{{ $leave->announcement ?: 'A clinic dentist will be on leave.' }} <b>({{ $leave->starts_on->format('M d') }}–{{ $leave->ends_on->format('M d, Y') }})</b></div>
            @endforeach
          </div>
        </div>
        @endif
        @if($errors->any())
        <div class="errors">
          <b>Please check the following:</b>
          <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <div class="da-progress" aria-label="Booking progress">
          @foreach(
            [
              1=>['Service','Select service'],
              2=>['Date & Time','Choose schedule'],
              3=>['Your Details','Enter information'],
              4=>['Confirmation','Review & confirm']
            ] as $number=>$label)
            
            <div class="da-progress-item {{ $number===1 ? 'active' : '' }}" data-progress="{{ $number }}">
              <div class="da-dot">{{ $number }}</div>
              <div class="da-step-name">{{ $label[0] }}</div>
              <div class="da-step-note">{{ $label[1] }}</div>
            </div>
          @endforeach
        </div>
        <form id="appointmentForm" action="{{ route('dental.appointment.store') }}" method="POST" novalidate>@csrf
          <section class="da-step active" data-step="1">
            <div class="da-card">
              <h2 class="da-heading">1. Select Dental Service</h2>
              <p class="da-help">What type of service do you need?</p>
              <div class="service-grid">
                @foreach($services as $serviceValue => $serviceLabel)
                  <label class="service-option">
                    <input type="checkbox" name="service[]" value="{{ $serviceValue }}" {{ in_array($serviceValue, $oldServices) ? 'checked' : '' }}>
                    <span class="service-tile">
                      <span class="service-icon {{ $serviceDetails[$serviceValue][2] }}">
                          <i class="fa {{ $serviceDetails[$serviceValue][1] }}"></i>
                      </span>
                      <span class="service-name">{{ $serviceLabel }}</span>
                      <hr>
                      <span class="service-description">
                        {{ $serviceDetails[$serviceValue][0] }}
                      </span>
                    </span>
                  </label>
                @endforeach
              </div>
            {{-- Update part --}}
              @if($hasActiveRequest)
                <div class="warning-strip" role="status">
                  <i class="fa fa-clock-o"></i>
                  You already have an active appointment request. You can book again after it is completed or cancelled.
                </div>
              @endif
              
              <div class="button-row" style="justify-content:flex-end;">
                <button type="button" class="btn-da primary next-button" data-next="2"
                  @if($hasActiveRequest) disabled aria-disabled="true" title="Complete or cancel your active request before booking another appointment." @endif>
                  Next: Choose Date & Time <i class="fa fa-arrow-right"></i>
                </button>
              </div>
              {{-- end here --}}
            </div>
          </section>
          <section class="da-step" data-step="2">
            <div class="da-card">
              <h2 class="da-heading">2. Choose Date & Time</h2>
              <p class="da-help">Select your preferred date and time.</p>
              <div class="da-schedule">
                <div class="date-card">
                  <label for="appointment_date" class="slot-title">Appointment Date</label>
                  <input id="appointment_date" name="appointment_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('appointment_date') }}" required>
                  <p class="date-tip"><i class="fa fa-calendar-o"></i> Clinic hours are Monday to Friday, 8:00 AM–5:00 PM.</p>
                </div>
                <div>
                  <div class="slot-title" id="availableTitle">Available Time</div>
                    <div id="dateLeaveAnnouncement" class="leave-announcement" hidden><i class="fa fa-info-circle"></i><div>
                      <strong>Schedule update</strong>
                      <span></span>
                    </div>
                  </div>
                  <input type="hidden" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}">
                  <div id="timeSlots" class="time-grid">
                    <div class="empty-times">Select a date to see available times.</div>
                  </div>
                </div>
              </div>
              <div class="button-row"><button type="button" class="btn-da outline back-button" data-back="1">
                <i class="fa fa-arrow-left"></i> Back</button>
                <button type="button" class="btn-da primary next-button" data-next="3">Next: Your Details <i class="fa fa-arrow-right"></i></button>
              </div>
            </div>
          </section>
          <section class="da-step" data-step="3">
            <div class="da-card">
              <h2 class="da-heading">3. Your Details</h2>
              <p class="da-help">Please provide the following information.</p>
              <div class="form-grid">
                <div class="field">
                  <label for="full_name">Full Name <span class="required">*</span></label>
                  <input id="full_name" name="full_name" value="{{ old('full_name') ?: $fullName }}" maxlength="255" required>
                </div>
                <div class="field">
                  <label for="patient_id">Student / Employee ID <span class="required">*</span></label>
                  <input id="patient_id" name="patient_id" value="{{ old('patient_id') ?: $patientId }}" maxlength="100" required >
                </div>
                <div class="field">
                  <label for="patient_type">Patient Type <span class="required">*</span></label>
                  <select id="patient_type" name="patient_type" required >
                    <option value="">Select type</option>
                    <option value="Student" {{ (old('patient_type') ?: ($patientDetails['patient_type'] ?? optional($user)->role))==='Student'?'selected':'' }}>Student</option>
                    <option value="Employee" {{ (old('patient_type') ?: ($patientDetails['patient_type'] ?? optional($user)->role))==='Employee'?'selected':'' }}>Employee</option>
                  </select>
                </div>
                <div class="field">
                  <label for="course_department">Course / Department</label>
                  <input id="course_department" name="course_department" value="{{ old('course_department') ?: ($patientDetails['course_department'] ?? '') }}" maxlength="255"></div>
                  <div class="field full">
                    <label for="contact_number">Contact Number <span class="required">*</span></label>
                    <input id="contact_number" name="contact_number" type="tel" value="{{ old('contact_number') ?: ($patientDetails['contact_number'] ?? optional($user)->contactNo ?? '') }}" maxlength="30" placeholder="09XX XXX XXXX" required>
                  </div>
                  <div class="field full">
                    <label for="reason_for_visit">Reason for Visit (Optional)</label>
                    <textarea id="reason_for_visit" name="reason_for_visit" maxlength="200" placeholder="e.g. Routine check-up, toothache, cleaning, etc.">{{ old('reason_for_visit') }}</textarea>
                    <div class="count">
                      <span data-count-for="reason_for_visit">0</span>/200
                    </div>
                    </div>
                    <div class="field full">
                      <label for="additional_notes">Additional Notes (Optional)</label>
                      <textarea id="additional_notes" name="additional_notes" maxlength="200" placeholder="Add any information you want the dentist to know.">{{ old('additional_notes') }}</textarea><div class="count"><span data-count-for="additional_notes">0</span>/200</div>
                    </div>
                  </div>
                  <div class="info-strip">
                    <i class="fa fa-info-circle"></i> Please ensure your information is correct to avoid issues with your appointment.
                  </div>
                  <div class="button-row">
                    <button type="button" class="btn-da outline back-button" data-back="2">
                      <i class="fa fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn-da primary next-button" data-next="4">
                      Next: Review Appointment <i class="fa fa-arrow-right"></i>
                    </button>
                  </div>
                </div>
              </section>
              <section class="da-step" data-step="4">
                <div class="da-card">
                  <h2 class="da-heading">4. Review & Confirm</h2>
                  <p class="da-help">Please review your appointment details and confirm your booking.</p>
                  <div class="review-box">
                    <div class="review-title">Appointment Details</div>
                    @foreach(
                      [
                        ['medkit','Service','reviewService'],
                        ['calendar','Date & Time','reviewSchedule'],
                        ['map-marker','Location','reviewLocation'],
                        ['user','Patient','reviewPatient'],
                        ['phone','Contact','reviewContact'],
                        ['file-text-o','Notes','reviewNotes']
                      ] as $review)
                      <div class="review-row">
                        <span class="review-symbol">
                          <i class="fa fa-{{ $review[0] }}"></i>
                        </span>
                        <span class="review-label">{{ $review[1] }}</span>
                        <span class="review-value" id="{{ $review[2] }}">—</span>
                      </div>
                    @endforeach
                  </div>
                  <div class="success-strip">
                    <i class="fa fa-check-circle"></i>
                    <div>
                      <b>Almost done!</b>
                      <br>Your appointment will be sent to the clinic for approval.
                    </div>
                  </div>
                  <div class="button-row">
                    <button type="button" class="btn-da outline back-button" data-back="3">
                      <i class="fa fa-arrow-left"></i> Back
                    </button>
                    <button id="confirmButton" type="submit" class="btn-da primary">
                      <i class="fa fa-check-circle-o"></i> Confirm Appointment
                    </button>
                  </div>
                </div>
              </section>
            </form>
        </main>
        <aside>
          <div class="da-panel side-panel">
            <h3 class="side-title">
            <span><i class="fa fa-calendar-o" style="color:var(--da-blue)"></i> Upcoming Appointment</span>
            <a href="{{ route('dental.appointment.index') }}">View All</a></h3>
              @if($upcomingAppointment)
                @include('pages.partials.dental-appointment-summary',['appointment'=>$upcomingAppointment])
              @else
              <p class="empty-copy">You have no upcoming dental appointment.</p>
              @endif
              @include('pages.partials.dental-request-status', ['appointment' => $latestAppointment])
              <div class="info-strip"><i class="fa fa-info-circle"></i><div><b>Reminder</b><br>Please arrive at least 15 minutes early.</div>
              </div>
            </div>
        </aside>
    </div>
    <div class="da-panel guideline-grid">
      @foreach([
        ['clock-o','Be on Time','Please arrive at least 10-15 minutes early.'],
        ['id-card-o','Bring Your ID','Bring your school or employee ID.'],
        ['clipboard','Health Information','Fill-up assessment questionnaire.'],
        ['smile-o','Oral Hygiene','Maintain proper oral hygiene.']
        ] as $guide)
        <div class="guide">
          <i class="fa fa-{{ $guide[0] }}"></i>
          <div>
            <b>{{ $guide[1] }}</b>
            <span>{{ $guide[2] }}</span>
          </div>
        </div>
        @endforeach
      </div>
@endif
</div>
</section>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
@if(!session('appointment_confirmed'))
<script>
$(document).ready(function () {
    var currentStep = 1;
    var oldTime = $('#appointment_time').val();
    var hasActiveRequest = @json($hasActiveRequest);

    function showValidationAlert(message) {
        Swal.fire({
            icon: 'warning',
            title: 'Required information',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#0758e8'
        });
    }

    $(document).on('click', '.reschedule-response-btn', function () {
        var button = $(this);
        var responseBox = button.closest('.reschedule-response');
        var buttons = responseBox.find('.reschedule-response-btn');
        var message = responseBox.find('.reschedule-response-message');

        buttons.prop('disabled', true);
        message.text('Saving your response...').show();

        $.ajax({
            url: @json(route('dental.appointment.reschedule-response')),
            type: 'POST',
            data: {
                appointment_id: button.data('appointment-id'),
                response: button.data('response'),
                _token: @json(csrf_token())
            },
            success: function (data) {
                message.css('color', '#157d3c').text(data.message);
                window.setTimeout(function () {
                    window.location.reload();
                }, 900);
            },
            error: function (xhr) {
                buttons.prop('disabled', false);
                message.css('color', '#b42335').text(
                    xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Unable to save your response. Please try again.'
                );
            }
        });
    });

    function showStep(step) {
        currentStep = step;

        $('.da-step').removeClass('active');
        $('.da-step[data-step="' + step + '"]').addClass('active');

        $('.da-progress-item').each(function () {
            var progressStep = parseInt($(this).data('progress'));

            $(this).removeClass('active done');
            $(this).find('.da-dot').text(progressStep);

            if (progressStep < step) {
                $(this).addClass('done');
                $(this).find('.da-dot').text('✓');
            }

            if (progressStep == step) {
                $(this).addClass('active');
            }
        });

        if (step == 4) {
            displayReview();
        }

    }

    function validateStep(step) {
        if (step == 1 && $('input[name="service[]"]:checked').length == 0) {
            showValidationAlert('Please select at least one dental service.');
            return false;
        }

        if (step == 2) {
            if ($('#appointment_date').val() == '') {
                showValidationAlert('Please select an appointment date.');
                return false;
            }

            if ($('#appointment_time').val() == '') {
                showValidationAlert('Please select an available appointment time.');
                return false;
            }
        }

        if (step == 3) {
            var requiredFields = ['full_name', 'patient_id', 'patient_type', 'contact_number'];

            for (var i = 0; i < requiredFields.length; i++) {
                var field = $('#' + requiredFields[i]);

                if (field.val().trim() == '') {
                    showValidationAlert('Please complete all required patient information.');
                    field.focus();
                    return false;
                }
            }
        }

        return true;
    }

    $('.next-button').click(function () {
        if (validateStep(currentStep)) {
            showStep(parseInt($(this).data('next')));
        }
    });

    $('.back-button').click(function () {
        showStep(parseInt($(this).data('back')));
    });

    $('#appointment_date').change(function () {
        loadAvailableTimes();
    });

    $('#patient_type').change(function () {
        if ($('#appointment_date').val()) {
            loadAvailableTimes();
        }
    });

    function loadAvailableTimes() {
        var selectedDate = $('#appointment_date').val();
        var url = @json(route('dental.appointment.available-times'));

        $('#appointment_time').val('');
        $('#timeSlots').html('<div class="empty-times">Loading available times...</div>');

        if (selectedDate == '') {
            $('#timeSlots').html('<div class="empty-times">Select a date to see available times.</div>');
            return;
        }

        $.get(url, {
            date: selectedDate,
            patient_type: $('#patient_type').val()
        }, function (response) {
            $('#timeSlots').html('');
            if (response.announcement) {
                $('#dateLeaveAnnouncement span').text(response.announcement);
                $('#dateLeaveAnnouncement').removeAttr('hidden');
            } else {
                $('#dateLeaveAnnouncement').attr('hidden', true);
            }

            if (response.available_times.length == 0) {
                var message = response.message || 'No available time slots for this date.';
                $('#timeSlots').html('<div class="empty-times">' + message + '</div>');
                return;
            }

            $.each(response.available_times, function (index, time) {
                var button = $('<button type="button" class="time-button"></button>');
                button.text(time.label);
                button.attr('data-time', time.value);

                if (oldTime == time.value) {
                    button.addClass('selected');
                    $('#appointment_time').val(time.value);
                    oldTime = '';
                }

                $('#timeSlots').append(button);
            });
        });
    }

    $(document).on('click', '.time-button', function () {
        $('.time-button').removeClass('selected');
        $(this).addClass('selected');
        $('#appointment_time').val($(this).data('time'));
    });

    function displayReview() {
        var selectedServices = [];

        $('input[name="service[]"]:checked').each(function () {
            selectedServices.push($(this).siblings('.service-tile').find('.service-name').text().trim());
        });

        var selectedDate = $('#appointment_date').val();
        var selectedTime = $('#appointment_time').val();
        var formattedDate = new Date(selectedDate + 'T00:00:00').toLocaleDateString('en-PH', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        var formattedTime = new Date('2000-01-01T' + selectedTime).toLocaleTimeString('en-PH', {
            hour: '2-digit',
            minute: '2-digit'
        });

        $('#reviewService').text(selectedServices.join(', '));
        $('#reviewSchedule').html(formattedDate + '<br><span style="color:#0758e8">' + formattedTime + '</span>');
        $('#reviewLocation').text(@json($clinicLocation));
        $('#reviewPatient').text($('#full_name').val() + ' (' + $('#patient_id').val() + ')');
        $('#reviewContact').text($('#contact_number').val());
        $('#reviewNotes').text($('#reason_for_visit').val() || 'No notes provided');
    }

    $('textarea[maxlength]').on('input', function () {
        var counter = $('[data-count-for="' + this.id + '"]');
        counter.text($(this).val().length);
    }).trigger('input');

    $('#appointmentForm').submit(function (event) {
        if (hasActiveRequest) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'You currently have an active appointment',
                text: 'You can request a new appointment once your current appointment is Done, Disapproved, or Cancelled.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0758e8'
            });
            return;
        }

        if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
            event.preventDefault();
            return;
        }

        $('#confirmButton').prop('disabled', true);
        $('#confirmButton').html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
    });

    if ($('#appointment_date').val() != '') {
        loadAvailableTimes();
    }

   
});
</script>
@endif
@endsection