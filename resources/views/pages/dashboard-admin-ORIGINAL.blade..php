@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Dashboard')
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}">
@endsection
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
    grid-template-columns:repeat(5,1fr);
    gap:12px;
    margin-bottom:18px
  }

  .status-filter{
    appearance:none;
    text-align:left;
    background:#fff;
    border:1px solid #dfe7f3;
    border-radius:13px;
    padding:15px;
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
    text-transform:uppercase}
  .status-filter b{display:block;color:#10275b;font-size:25px;margin-top:5px}
  .status-filter.for-approval{border-left:4px solid #f07800;background:#fff8ed}
  .status-filter.pending{border-left:4px solid #e09a00}
  .status-filter.approved{border-left:4px solid #159751}
  .status-filter.disapproved{border-left:4px solid #cf3347}
  .status-filter.rescheduled{border-left:4px solid #7953c6}
  .status-filter.all{border-left:4px solid #0758e8}
  .status-panel{background:#fff;border:1px solid #dfe7f3;border-radius:15px;box-shadow:0 6px 22px rgba(18,48,96,.06);overflow:hidden}
  .status-toolbar{display:flex;justify-content:space-between;align-items:center;gap:14px;padding:17px 19px;border-bottom:1px solid #e5ebf4}.status-toolbar h3{font-size:17px;font-weight:800;margin:0}.status-search{width:270px;max-width:100%;border:1px solid #d7e0ee;border-radius:9px;padding:9px 12px}
  .status-table-wrap{overflow-x:auto}.status-table{width:100%;border-collapse:collapse}.status-table th{background:#f5f8fd;color:#596984;font-size:11px;text-transform:uppercase;letter-spacing:.03em;text-align:left;padding:12px 14px}.status-table td{border-top:1px solid #edf1f7;padding:13px 14px;vertical-align:middle}.status-table tbody tr:hover{background:#fbfdff}
  .patient-name{font-weight:750;color:#10275b}.patient-meta,.service-meta{color:#71809a;font-size:11px;margin-top:3px}.service-name{font-weight:650;color:#344b70;max-width:260px}
  .status-pill{display:inline-block;border-radius:20px;padding:5px 10px;font-size:14px;font-weight:800;}.status-pill.for-approval{background:#ffe0b2;color:#9a4300;border:1px solid #ffbd66}.status-pill.pending{background:#fff2cf;color:#865a00}.status-pill.approved{background:#e0f5e8;color:#14743d}.status-pill.disapproved{background:#ffe5e8;color:#b42335}.status-pill.rescheduled{background:#f1eaff;color:#6440ad}
  .reason{color:#b42335;font-size:11px;margin-top:4px;max-width:220px}.schedule-cell{white-space:nowrap;color:#344b70}.schedule-cell b{display:block;color:#10275b}.action-group{display:flex;flex-direction:column;align-items:stretch;gap:6px;min-width:105px}.action-btn{border:0;border-radius:7px;padding:7px 9px;font-size:11px;font-weight:750;cursor:pointer;white-space:nowrap;text-align:center}.action-btn.approve{background:#e0f5e8;color:#14743d}.action-btn.disapprove{background:#ffe5e8;color:#b42335}.action-btn.reschedule{background:#f1eaff;color:#6440ad}.action-done{color:#8a96aa;font-size:11px}
  .reschedule-fields{display:grid;grid-template-columns:1fr 1fr;gap:12px;text-align:left;margin-top:12px}.reschedule-fields label{display:block;color:#52617b;font-size:12px;font-weight:700;margin-bottom:5px}.reschedule-fields input{width:100%;border:1px solid #d7e0ee;border-radius:8px;padding:9px 10px;color:#10275b}
  .status-empty{text-align:center;color:#7b879c;padding:35px!important}
  .schedule-dashboard-panel{margin:0 0 24px;padding:20px;background:#fff;border:1px solid #dfe7f3;border-radius:16px;box-shadow:0 7px 24px rgba(18,48,96,.07)}
  .schedule-hero{display:flex;justify-content:space-between;gap:20px;align-items:center;margin:0 0 18px}
  .schedule-hero h2{color:#10275b;font-size:26px;font-weight:800;margin:0 0 5px}.schedule-hero p{color:#687694;margin:0}
  .schedule-date{background:#edf4ff;color:#0758e8;border-radius:10px;padding:10px 14px;font-weight:700;white-space:nowrap}
  .schedule-stats{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:18px}
  .schedule-stat{background:#fff;border:1px solid #dfe7f3;border-radius:13px;padding:17px;box-shadow:0 5px 18px rgba(18,48,96,.05)}
  .schedule-stat span{display:block;color:#6a7894;font-size:12px;font-weight:700;text-transform:uppercase}
  .schedule-stat b{display:block;color:#10275b;font-size:27px;line-height:1.2;margin-top:6px}
  .schedule-stat.today{border-left:4px solid #0758e8}
  .schedule-stat.upcoming{border-left:4px solid #7258d6}
  .schedule-stat.pending{border-left:4px solid #e5a000}
  .schedule-stat.approved{border-left:4px solid #1a9b55}
  .schedule-stat.rescheduled{border-left:4px solid #9a67d8}
  .schedule-columns{display:grid;grid-template-columns:1fr 1fr;gap:18px}
  .schedule-panel{background:#fff;border:1px solid #dfe7f3;border-radius:14px;overflow:hidden;box-shadow:0 5px 18px rgba(18,48,96,.05)}
  .schedule-panel-head{display:flex;justify-content:space-between;align-items:center;padding:16px 18px;border-bottom:1px solid #e5ebf4}.schedule-panel-head h3{color:#10275b;font-size:17px;font-weight:800;margin:0}.schedule-panel-head span{color:#6a7894;font-size:12px}
  .schedule-list{padding:3px 18px}.schedule-row{display:grid;grid-template-columns:74px minmax(0,1fr) auto;gap:13px;align-items:center;padding:13px 0;border-bottom:1px solid #edf1f7}.schedule-row:last-child{border-bottom:0}
  .schedule-when{color:#0758e8;font-size:12px;font-weight:800}
  .schedule-when small{display:block;color:#6a7894;font-weight:600;margin-top:3px}
  .schedule-patient{color:#10275b;font-weight:750;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .schedule-service{color:#6a7894;font-size:12px;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .schedule-pill{border-radius:20px;padding:5px 9px;font-size:14px;font-weight:800}
  .schedule-pill.for-approval{background:#ffe0b2;color:#9a4300;border:1px solid #ffbd66}
  .schedule-pill.pending{background:#fff2cf;color:#865a00}
  .schedule-pill.approved{background:#e0f5e8;color:#14743d}
  .schedule-pill.rescheduled{background:#f3edff;color:#6542b5}
  .schedule-pill.disapproved,.schedule-pill.cancelled{background:#ffe5e8;color:#b42335}.schedule-pill.done,.schedule-pill.completed{background:#e5eefc;color:#315f9e}
  .schedule-empty{color:#78859d;text-align:center;padding:30px 15px}
  @media(max-width:1000px){.status-cards{grid-template-columns:repeat(3,1fr)}}
  @media(max-width:900px){.schedule-stats{grid-template-columns:repeat(2,1fr)}.schedule-columns{grid-template-columns:1fr}}
  @media(max-width:650px){.status-head,.status-toolbar,.schedule-hero{align-items:flex-start;flex-direction:column}.status-cards{grid-template-columns:repeat(2,1fr)}.status-search{width:100%}.schedule-row{grid-template-columns:64px minmax(0,1fr)}.schedule-pill{grid-column:2;justify-self:start}}
</style>
@section('content')
@php
  $formatPurpose = function ($purpose) {
      if (is_array($purpose)) return implode(', ', $purpose);
      $decoded = json_decode((string) $purpose, true);
      return is_array($decoded) ? implode(', ', $decoded) : ((string) $purpose ?: '—');
  };
  $dashboardStatusClass = function ($status) {
      $value = strtolower(trim((string) $status));
      return $value === 'for approval' ? 'for-approval' : str_replace(' ', '-', $value);
  };
@endphp
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="user-profile-images position-relative">
            <img src="{{asset('images/logo/king-fisher-dashboard.png')}}" class="img-fluid w-100 rounded-top" style="max-width: 100%; max-height: 50%" alt="GEMS Banner">
            <div class="position-absolute d-flex align-items-center" style="bottom: -40px; left: 20px;">
              <img src="{{ session('photo') ? session('photo') : asset('images/icon/default-profile.png') }}" 
                   class="user-profile-image rounded-circle border" 
                   alt="User Profile Image" height="90" width="90">
              <div class="ms-1">
                <h5 class="text-bold-500 profile-text-color text-white" style=" margin-left: 10px;">{{ session('name') }}</h5>
               @php
                  $campuses = [
                      1 => 'Main Campus',
                      2 => 'Maasin City Campus',
                      3 => 'Tomas Oppus Campus',
                      4 => 'Bontoc Campus',
                      5 => 'San Juan Campus',
                      6 => 'Hinunangan Campus',
                  ];
              @endphp

              <medium style="margin-left: 10px; font-weight: 500;">
                  {{ $campuses[session('campus')] ?? 'Unknown Campus' }}
              </medium>

              </div>
            </div>
          </div>
          <div class="card-body px-2 mt-1">
            {{-- <h4 class="card-title">DASHBOARD</h4> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

   <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title text-uppercase text-muted mb-0" style="font-weight:600;">MEDICAL SERVICES</h5>
            <span class="d-block text-nowrap font-weight-bold">Total # of Student</span>
            <h2 class="font-weight-bold mb-0">{{$totalStudMS}}</h2>
            <span class="d-block text-nowrap font-weight-bold">Total # of Employee</span>
            <h2 class="font-weight-bold mb-0">{{$totalEmployeeMS}}</h2>
            <hr>  
            <div class="row justify-content-between align-items-center">
                <h6 class="card-title text-muted mb-0">Records of Visits <b>{{$total_records}}</b></h6>
                <a href="/medical-record-of-visit" class="card-box-footer ml-auto">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title text-uppercase text-muted mb-0" style="font-weight:600;">DENTAL SERVICES</h5>
            <span class="d-block text-nowrap font-weight-bold">Total # of Student</span>
            <h2 class="font-weight-bold mb-0">{{$totalStudDS}}</h2>
            <div class="row">
              <div class="col-md-6">
                  <span class="d-block text-nowrap font-weight-bold">Total # of Employee</span>
                  <h2 class="font-weight-bold mb-0">{{$totalEmployeeDS}}</h2>
              </div>
              <div class="col-md-6">
                  <span class="d-block text-nowrap font-weight-bold">Total # of Dependent</span>
                  <h2 class="font-weight-bold mb-0">{{$totalDependentDS}}</h2>
              </div>
          </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="card-title text-muted mb-0">Records of Visits <b>{{$total_recordsVisit}}</b></h6>
              <a href="/records-of-visit" class="card-box-footer" >View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="schedule-dashboard-panel">
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
  </div>

  
   


   
    {{-- <div class="row"> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Record of Visit</h5>
                <span class="h2 font-weight-bold mb-0">{{$total_records}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-users fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/medical-record-of-visit" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Consultation</h5>
                <span class="h2 font-weight-bold mb-0">{{$total_consultation}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-stethoscope fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/medical-record-of-visit" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>  --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Issuance of Certificate</h5>
                <span class="h2 font-weight-bold mb-0">{{ $total_issuedcert }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-certificate fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/medical-issuance-of-certificate" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Schedule Today</h5>
                <span class="h2 font-weight-bold mb-0">{{$scheduleToday}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-calendar fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/view-appointment" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Rescheduled Today</h5>
                <span class="h2 font-weight-bold mb-0">{{$rescheduled}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-dark text-white rounded-circle shadow">
                  <i class="fa fa-calendar-o fa-2x"></i>
                </div>
              </div>
            </div> 
            <hr>
            <a href="/view-appointment" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div> --}}
    {{-- <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Issuance of Slip</h5>
                <span class="h2 font-weight-bold mb-0">{{ $total_referral }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-file-text-o fa-2x"></i>
                </div>
              </div>
            </div> 
            <hr>
            <a href="/medical-issuance-of-slip" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">OTC Medicines</h5>
               
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-suitcase fa-2x"></i>
                </div>
              </div>
            </div> 
            <hr>
            <a href="/medical-OTC-medicine" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Oral Prophylaxis</h5>
               
              </div>
              <div class="col-auto">
                <span class="h2 font-weight-bold mb-0">{{$oralprophylaxis}}</span>
            </div>
            </div>
            <hr>
            <a href="/records-of-oralprophylaxis" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Tooth Extraction</h5>
                
              </div>
              <div class="col-auto">
                <span class="h2 font-weight-bold mb-0">{{$toothextraction}}</span>
            </div>
            </div> 
            <hr>
            <a href="/records-of-toothextraction" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>   --}}
      {{-- <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h6 class="card-title text-uppercase text-muted mb-0">Dental Services</h6>
                
              </div> --}}
              {{-- <div class="col-auto">
                  <span class="h2 font-weight-bold mb-0">{{$dentalcheckup}}</span>
              </div> --}}
            {{-- </div> --}}
            {{-- <hr>
            <a href="/records-of-checkup" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a> --}}
          {{-- </div>
        </div>
      </div> --}}
 

    {{-- </div>
    <div class="row">

      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Provision of Comfort</h5>
                <span class="h2 font-weight-bold mb-0">{{ $total_provision }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-bed fa-2x"></i>
                </div>
              </div>
            </div> 
            <hr>
            <a href="/medical-provision-of-comfort" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Blood Pressure</h5>
                <span class="h2 font-weight-bold mb-0">{{$total_bp}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-heartbeat fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/medical-blood-pressure" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Dental Check-up</h5>
                
              </div>
              <div class="col-auto">
                  <span class="h2 font-weight-bold mb-0">{{$dentalcheckup}}</span>
              </div>
            </div>
            <hr>
            <a href="/records-of-checkup" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Cavity Filling</h5>
                
              </div>
              <div class="col-auto">
                <span class="h2 font-weight-bold mb-0">{{$cavityfilling}}</span>
            </div>
            </div>
            <hr>
            <a href="/records-of-cavityfilling" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div> --}}
    {{-- <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Wound Dressing</h5>
                <span class="h2 font-weight-bold mb-0">{{$total_wound_dressing}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-medkit fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/medical-wound-dressing" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Record of Visit</h5>
                <span class="h2 font-weight-bold mb-0">{{$total_recordsVisit}}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-users fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/records-of-visit" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Other Concerns</h5>
                <span class="h2 font-weight-bold mb-0">{{ $total_others }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-light text-white rounded-circle shadow">
                  <i class="fa fa-file-word-o fa-2x"></i>
                </div>
              </div>
            </div> 
            <hr>
            <a href="/medical-other-concern" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div> --}}
  {{-- <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Referral Slip</h5>
              <h6 class="card-sub-title text-capitalize text-muted mb-0">(PENDING FOR APPROVAL)</h6>
              <span class="h2 font-weight-bold mb-0">{{$total}}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                <i class="fa fa-file-text-o fa-2x"></i>
              </div>
            </div>
          </div>
          <hr>
          <a href="/view-generated-slip" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div> --}}

</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-scripts')
{{-- <script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script> --}}
@endsection

@section('page-scripts')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script>
@endsection
