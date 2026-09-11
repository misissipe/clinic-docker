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

@section('content')
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
                <medium style=" margin-left: 10px;font-weight:500px">{{session('role')}}</medium>
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
      
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Consultation</h5>
                <span class="h2 font-weight-bold mb-0"></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                  <i class="fa fa-stethoscope fa-2x"></i>
                </div>
              </div>
            </div>
            <hr>
            <a href="/medical-wound-dressing" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Issuance of Certificate</h5>
                <span class="h2 font-weight-bold mb-0"></span>
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
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Schedule Today</h5>
                <span class="h2 font-weight-bold mb-0"></span>
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
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Rescheduled Today</h5>
                <span class="h2 font-weight-bold mb-0"></span>
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
    </div>

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

