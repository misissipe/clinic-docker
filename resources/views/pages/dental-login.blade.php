@extends('layouts.fullLayoutMaster')

@section('title', 'Dental Appointment Login')

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/authentication.css') }}">
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
                <img src="{{ asset('images/logo/logo slsu.png') }}" alt="SLSU logo" width="150">
                <h4 class="mt-2 mb-50">Dental Appointment</h4>
                <p class="text-muted">For students and employees</p>
              </div>
            </div>

            <div class="card-content">
              <div class="card-body">
                @if ($errors->any())
                  <div class="alert alert-danger">
                    {{ $errors->first() }}
                  </div>
                @endif

                <ul class="nav nav-tabs justify-content-center mb-2" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link {{ old('form_type', 'login') === 'login' ? 'active' : '' }}"
                       data-toggle="tab" href="#patient-login" role="tab">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ old('form_type') === 'signup' ? 'active' : '' }}"
                       data-toggle="tab" href="#patient-signup" role="tab">Sign Up</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane fade {{ old('form_type', 'login') === 'login' ? 'show active' : '' }}"
                       id="patient-login" role="tabpanel">
                    <form action="{{ route('dental.login.submit') }}" method="post">
                      @csrf
                      <input type="hidden" name="form_type" value="login">
                      @include('pages.partials.dental-patient-fields', ['buttonText' => 'Login'])
                    </form>
                  </div>

                  <div class="tab-pane fade {{ old('form_type') === 'signup' ? 'show active' : '' }}"
                       id="patient-signup" role="tabpanel">
                    <form action="{{ route('dental.signup') }}" method="post">
                      @csrf
                      <input type="hidden" name="form_type" value="signup">
                      @include('pages.partials.dental-patient-fields', [
                        'buttonText' => 'Sign Up',
                        'showConfirmation' => true,
                      ])
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
          <img class="img-fluid" src="{{ asset('images/pages/register.png') }}" alt="Dental appointment login">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
