@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Login Page')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<section id="auth-login" class="row flexbox-container">
  <div class="col-xl-8 col-11">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
              <div class="card-title text-center">
                <img src="{{asset('images/logo/logo slsu.png')}}" alt="branding logo"  width="170">
                <br>
                <h4 class="text-center mb-2">
                  <br>
                  CMIS Dental Appointment
                 </h4>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="/appointmentLogin"  method="post" id="generatedCert">
                  @csrf
                  <label class="text-bold-600" for="idnumber">Campus<span class="text-danger">*</span></label>
                  <select id="campus" name="campus" class="form-control" aria-label="Default select example" required>
                    <option selected>-Select-</option>
                    <option value="1">Main Campus</option>
                    <option value="2">Maasin</option>
                    <option value="3">Tomas Oppus</option>
                    <option value="4">Bontoc</option>
                    <option value="5">San Juan</option>
                    <option value="6">Hinunangan</option>
                </select>
                  <div class="form-group mb-50">
                    <label class="text-bold-600" for="idnumber">ID Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="idnumber"  name="idnumber" placeholder="ID Number" required>
                  </div>
                  {{-- <div class="form-group">
                    <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div> --}}
                  <button type="submit" class="btn btn-primary glow position-relative w-100">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
          <div class="card-content">
            <img class="img-fluid" src="{{asset('images/pages/login.png')}}" alt="branding logo">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection