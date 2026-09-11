@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Register')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- register section starts -->
<section class="row flexbox-container">
  <div class="col-xl-8 col-10">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="text-center mb-2">Welcome to CMIS</h4>
              </div>
            </div>
            <ul class="nav nav-tabs justify-content-center mb-2" id="authTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab">
                  Login
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab">
                  Sign Up
                </a>
              </li>
            </ul>
            <div class="tab-content" id="authTabContent">
              <!-- LOGIN TAB -->
              <div class="tab-pane fade show active" id="login" role="tabpanel">
                <div class="text-center">
                  <p>
                    <small>Please enter your account details</small>
                  </p>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <form  action="/patient-appointment-dashboard" method="post" id="submitBtn">
                      @csrf
                      <div class="form-group mb-50">
                        Choose type:
                        <select id="role" name='role' class="form-control" aria-label="Default select example">
                          <option disabled selected>-Select Role-</option>
                          <option value="Student">Student</option>
                          <option value="Employee">Employee</option>
                        </select>
                      </div>
                      <div class="form-group mb-50">
                        <label class="text-bold-600">Username</label>
                        <input type="text" class="form-control" placeholder="Username">
                      </div>
                      <div class="form-group mb-2">
                        <label class="text-bold-600">Password</label>
                        <input type="password" class="form-control" placeholder="Password">
                      </div>
                      <button type="submit" class="btn btn-primary glow position-relative w-100">LOGIN <i class="bx bx-right-arrow-alt"></i></button>
                    </form>
                  </div>
                </div>
            </div>
            <!-- SIGN UP TAB -->
            <div class="tab-pane fade" id="signup" role="tabpanel">
              <div class="text-center">
                <p>
                  <small>Please enter your details to sign up</small>
                </p>
              </div>
            <div class="card-content">
              <div class="card-body">
                <form  action="/patient-appointment-dashboard" method="post" id="submitBtn">
                  @csrf
                  <div class="form-group mb-50">
                    Choose type:
                    <select id="role" name='role' class="form-control" aria-label="Default select example">
                      <option disabled selected>-Select Role-</option>
                      <option value="Student">Student</option>
                      <option value="Employee">Employee</option>
                    </select>
                  </div>
                  <div class="form-group mb-50">
                    <label class="text-bold-600">Username</label>
                    <input type="text" name='username' class="form-control" placeholder="Username">
                  </div>
                  <div class="form-group mb-2">
                    <label class="text-bold-600">Password</label>
                    <input type="password" name='password' class="form-control" placeholder="Password">
                  </div>
                  <button type="submit"
                    class="btn btn-primary glow position-relative w-100">SIGN UP<i class="bx bx-right-arrow-alt"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


                <!-- Image Section -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">

                    <img class="img-fluid"
                        src="{{asset('images/pages/register.png')}}"
                        alt="branding logo">

                </div>


            </div>
        </div>
    </div>
</section>
<!-- register section endss -->
@endsection
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
<script>

</script>