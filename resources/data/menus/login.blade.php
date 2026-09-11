@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','CMIS - Login Page')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- login page start -->
<section id="auth-login" class="row flexbox-container">
  <div class="col-xl-8 col-11">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-login -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
              <div class="card-title text-center">
                <img src="{{asset('images/logo/logo slsu.png')}}" alt="CMIS - Southern Leyte State Uniersity"  width="170"><br><br>
                <span class="text-center mb-2" style="font-size:30px">
                  <strong>
                  CMIS
                  </strong>
                </span><br>
                Clinic Management Information System
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="d-flex flex-md-row flex-column justify-content-around">
                  <a href="{{route('google.signin')}}" class="btn btn-outline-primary gloew w-100 position-relative">
                 <img src="{{asset('images/logo/google.png')}}" alt="Sign-In" width="20">
                 Sign in with Google          
                  </a>    
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
          <div class="card-content">
            <img class="img-fluid" src="{{asset('images/pages/login.png')}}" alt="Sign-in with Google for MyCMIS">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- login page ends -->
@endsection
