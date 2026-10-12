@extends('layouts.contentLayoutMaster')
@section('title', 'Clinic Analytics')

@section('vendor-styles')
<link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
@endsection

@section('content')
<style>
  .analytics-page{color:#183153}
  .analytics-head{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
  .analytics-head h2{font-weight:800;margin:0 0 4px;color:#183153}
  .analytics-head p{margin:0;color:#71809a}
  .year-filter{display:flex;align-items:center;gap:9px;background:#fff;border:1px solid #e0e7f1;border-radius:10px;padding:8px 11px;box-shadow:0 5px 16px rgba(31,58,92,.05)}
  .year-filter label{margin:0;font-size:12px;font-weight:700;color:#71809a}
  .year-filter select{border:0;outline:0;color:#183153;font-weight:700;background:#fff}
  .kpi-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px;margin-bottom:18px}
  .kpi-card{position:relative;background:#fff;border:1px solid #e1e8f2;border-radius:14px;padding:18px;overflow:hidden;box-shadow:0 7px 22px rgba(31,58,92,.06)}
  .kpi-card:after{content:"";position:absolute;right:-18px;bottom:-30px;width:88px;height:88px;border-radius:50%;background:var(--soft)}
  .kpi-icon{display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:10px;background:var(--soft);color:var(--accent);font-size:20px;margin-bottom:14px}
  .kpi-label{color:#71809a;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}
  .kpi-value{font-size:27px;font-weight:800;color:#183153;line-height:1.2;margin-top:4px}
  .analytics-grid{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px}
  .analytics-grid.equal{grid-template-columns:1fr 1fr}
  .chart-card{background:#fff;border:1px solid #e1e8f2;border-radius:14px;box-shadow:0 7px 22px rgba(31,58,92,.06);overflow:hidden}
  .chart-head{padding:17px 19px;border-bottom:1px solid #edf1f6}
  .chart-head h4{font-size:16px;font-weight:800;color:#183153;margin:0}
  .chart-head p{font-size:11px;color:#8390a5;margin:3px 0 0}
  .chart-body{padding:12px 16px 16px;min-height:320px}
  .status-list{padding:12px 18px}
  .status-row{display:flex;justify-content:space-between;align-items:center;padding:11px 0;border-bottom:1px solid #edf1f6}
  .status-row:last-child{border:0}
  .status-name{display:flex;align-items:center;gap:9px;color:#52657d;font-weight:600}
  .status-dot{width:9px;height:9px;border-radius:50%;background:#5a8dee}
  .status-count{font-weight:800;color:#183153}
  .empty-state{text-align:center;color:#8a96aa;padding:60px 20px}
  @media(max-width:1100px){.kpi-grid{grid-template-columns:repeat(3,1fr)}}
  @media(max-width:800px){.analytics-grid,.analytics-grid.equal{grid-template-columns:1fr}.kpi-grid{grid-template-columns:repeat(2,1fr)}.analytics-head{align-items:flex-start;flex-direction:column}}
  @media(max-width:480px){.kpi-grid{grid-template-columns:1fr}}
</style>

<section class="analytics-page">
  <div class="analytics-head">
    <div>
      <h2>Clinic Analytics</h2>
      <p>Medical, dental, appointment, and assessment activity for {{ $year === 'all' ? 'all years' : $year }}.</p>
    </div>
    <form method="get" action="{{ route('analytics.dashboard') }}" class="year-filter">
      <label for="analyticsYear">Reporting Year</label>
      <select id="analyticsYear" name="year" onchange="this.form.submit()">
        @foreach($availableYears as $availableYear)
          <option value="{{ $availableYear }}" {{ (string) $availableYear === (string) $year ? 'selected' : '' }}>{{ $availableYear }}</option>
        @endforeach
        <option value="all" {{ $year === 'all' ? 'selected' : '' }}>All Years</option>
      </select>
    </form>
  </div>

  <div class="kpi-grid">
    <div class="kpi-card" style="--accent:#5a8dee;--soft:#eaf1ff"><div class="kpi-icon"><i class="bx bx-plus-medical"></i></div><div class="kpi-label">Total Encounters</div><div class="kpi-value">{{ number_format($kpis['encounters']) }}</div></div>
    <div class="kpi-card" style="--accent:#00a884;--soft:#e5f8f3"><div class="kpi-icon"><i class="bx bx-user"></i></div><div class="kpi-label">Total Patients</div><div class="kpi-value">{{ number_format($kpis['patients']) }}</div></div>
    <div class="kpi-card" style="--accent:#f59e0b;--soft:#fff5dd"><div class="kpi-icon"><i class="bx bx-calendar"></i></div><div class="kpi-label">Appointments</div><div class="kpi-value">{{ number_format($kpis['appointments']) }}</div></div>
    <div class="kpi-card" style="--accent:#8b5cf6;--soft:#f1ebff"><div class="kpi-icon"><i class="bx bx-clipboard"></i></div><div class="kpi-label">Assessments</div><div class="kpi-value">{{ number_format($kpis['assessments']) }}</div></div>
    <div class="kpi-card" style="--accent:#ef476f;--soft:#ffe9ef"><div class="kpi-icon"><i class="bx bx-check-circle"></i></div><div class="kpi-label">Completion Rate</div><div class="kpi-value">{{ $kpis['completion_rate'] }}%</div></div>
  </div>

  <div class="analytics-grid">
    <div class="chart-card">
      <div class="chart-head"><h4>Monthly Activity</h4><p>Medical and dental encounters by month</p></div>
      <div class="chart-body"><div id="activityTrend"></div></div>
    </div>
    <div class="chart-card">
      <div class="chart-head"><h4>Patient Types</h4><p>Medical and dental encounters</p></div>
      <div class="chart-body"><div id="patientRoles"></div></div>
    </div>
  </div>

  <div class="analytics-grid equal">
    <div class="chart-card">
      <div class="chart-head"><h4>Medical Services</h4><p>Services delivered during {{ $year === 'all' ? 'all years' : $year }}</p></div>
      <div class="chart-body"><div id="medicalServices"></div></div>
    </div>
    <div class="chart-card">
      <div class="chart-head"><h4>Dental Services</h4><p>Dental procedures recorded during {{ $year === 'all' ? 'all years' : $year }}</p></div>
      <div class="chart-body"><div id="dentalServices"></div></div>
    </div>
  </div>

  <div class="chart-card">
    <div class="chart-head"><h4>Appointment Status</h4><p>Current outcome of appointments scheduled in {{ $year === 'all' ? 'all years' : $year }}</p></div>
    @if($appointmentStatuses->isEmpty())
      <div class="empty-state">No appointment data is available for {{ $year === 'all' ? 'all years' : $year }}.</div>
    @else
      <div class="status-list">
        @foreach($appointmentStatuses as $status)
          <div class="status-row"><div class="status-name"><span class="status-dot"></span>{{ $status->status ?: 'Unknown' }}</div><div class="status-count">{{ number_format($status->total) }}</div></div>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection

@section('vendor-scripts')
<script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
@endsection

@section('page-scripts')
<script>
$(function () {
  var noData = {text:'No data available',align:'center',verticalAlign:'middle',style:{color:'#8a96aa',fontSize:'13px'}};

  new ApexCharts(document.querySelector('#activityTrend'), {
    chart:{type:'area',height:300,toolbar:{show:false}},
    series:[
      {name:'Medical',data:@json($trend['medical'])},
      {name:'Dental',data:@json($trend['dental'])}
    ],
    colors:['#5a8dee','#00a884'],
    stroke:{curve:'smooth',width:2.5},fill:{type:'gradient',gradient:{opacityFrom:.28,opacityTo:.03}},
    dataLabels:{enabled:false},xaxis:{categories:@json($trend['labels'])},yaxis:{min:0,forceNiceScale:true},
    grid:{borderColor:'#edf1f6'},legend:{position:'top'},noData:noData
  }).render();

  new ApexCharts(document.querySelector('#patientRoles'), {
    chart:{type:'donut',height:300},series:@json($roleCounts->values()),labels:@json($roleCounts->keys()),
    colors:['#5a8dee','#00a884','#f59e0b','#8a96aa'],stroke:{width:0},legend:{position:'bottom'},
    plotOptions:{pie:{donut:{size:'66%',labels:{show:true,total:{show:true,label:'Encounters'}}}}},noData:noData
  }).render();

  new ApexCharts(document.querySelector('#medicalServices'), {
    chart:{type:'bar',height:310,toolbar:{show:false}},series:[{name:'Records',data:@json($medicalServiceCounts)}],
    colors:['#5a8dee'],plotOptions:{bar:{horizontal:true,borderRadius:4,barHeight:'60%'}},
    dataLabels:{enabled:false},xaxis:{categories:@json($medicalServices),min:0},grid:{borderColor:'#edf1f6'},noData:noData
  }).render();

  new ApexCharts(document.querySelector('#dentalServices'), {
    chart:{type:'bar',height:310,toolbar:{show:false}},series:[{name:'Records',data:@json($dentalServiceCounts)}],
    colors:['#00a884'],plotOptions:{bar:{horizontal:true,borderRadius:4,barHeight:'55%'}},
    dataLabels:{enabled:false},xaxis:{categories:@json($dentalServices),min:0},grid:{borderColor:'#edf1f6'},noData:noData
  }).render();
});
</script>
@endsection
