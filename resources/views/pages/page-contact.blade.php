@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Contact')

@section('content')
<!-- maintenance start -->
<section class="row flexbox-container">
  <div class="col-xl-7 col-md-8 col-12">
    <div class="card bg-transparent shadow-none">
      <div class="card-content">
        <div class="card-body text-center bg-transparent miscellaneous">
          <img src="{{asset('images/pages/maintenance-2.png')}}" class="img-fluid" alt="under maintenance"
            width="400">
          <h1 class="error-title my-1">Good Day!</h1>
          <p class="px-2">
            Please contact University Information and System Analytics (UISA)/(CISA) for Activation or <a href="mailto:southernleytestateu.edu.ph">contact us</a>, Thank you and God Bless!
          </p>
          <a href="{{asset('/login')}}" class="btn btn-primary round glow mt-2">BACK TO HOME</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- maintenance end -->
@endsection