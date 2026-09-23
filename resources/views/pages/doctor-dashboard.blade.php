@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Dashboard')
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
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
              </div>
            </div>
          </div>
        </div>
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script>
@endsection

