@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Referral Slip')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    table, th,td{
  border: 1px solid rgb(58, 57, 57);
  border-collapse: collapse;
  padding: 1px;
  text-align: center;
  }

    .container {
      display: flex;
      justify-content: space-between;
    }

    td.a{
      text-align: right;
      vertical-align: bottom;
      }

    input {
      outline: 0;
      border-width: 0;
      border-color: rgb(58, 57, 57);
    }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
    
    }
  .textbox {
    transform: scale(1.5);
    margin: 4px;
    accent-color: rgb(58, 57, 57);
    width: 50px;
  }
  textarea  {
      outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57)
    
    }
  label {
    text-transform: lowercase;
  }

  label::first-letter {
    text-transform: uppercase;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  br.break {
  display: block;
  margin-bottom: 1px;
  line-height: 1px;
 }
 .card {
 
 margin-bottom: 50px;
 margin-left: auto;
 margin-right: auto;
  }
  .pending-status {
    color: rgb(99, 175, 211); 
    text-shadow:  5px rgba(113, 207, 238, 0.5);
  }

  .approved-status {
    color:  rgb(99, 211, 108); 
    text-shadow:  5px rgba(113, 238, 121, 0.5);
  }

  .disapproved-status {
    color: rgb(211, 99, 99); 
    text-shadow:  5px rgba(238, 113, 113, 0.5);
  }
  .btn-sm {
    width: 70px;
  }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          @if (isset($view))
          @if ($role === 'Student')
          <div class="card-body">
            <div class="table-responsive">
              <h5 style="font-weight: bold; display: flex; align-items: center;">PATIENT INFORMATION</h5>
              <form  action="/saveReferral" method="post" id="saveRefer">
               @csrf
                <input  class="form-control id col-2" type="hidden" name="patientId" value="{{$cipher}}" id="id" >
                <input  class="form-control " name="role" type="" value="{{$role}}" id="" hidden>  
                <input  class="form-control " name="findings" type="hidden" value="REFERRAL SLIP" id="" > 
                <input  class="form-control " name="purpose" type="" value="Referral" id="" hidden> 
                <input  class="form-control " name="accro" type="" value="{{$view->accro}}" id="" hidden> 
                <input  class="form-control " name="sex" type="" value="{{$view->Sex}}" id="" hidden>
                <div style="text-align: right">
                  <label style="display: center; margin-right: 10px;">Date:</label>
                  <input  class="form-control date col-sm-2 course cert float-right" name="date" type="date" value="{{ date('Y-m-d') }}" id="date">
                </div>
                <div class="form-group col-12">
                  <div style="font-weight: 500; font-size: 15px;font-style: bold;">REFERRED TO:<span class="text-danger">*</span></div>
                  <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="hospital" name="referTo[]" value="Hospital" onclick="selectCheckbox('hospital')">
                    <label for="hospital">HOSPITAL</label>
                  </div>
                  <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="rhu" name="referTo[]" value="RHU" onclick="selectCheckbox('rhu')">
                    <label for="rhu">RHU</label>
                  </div> 
                  <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="visiting_physician" name="referTo[]" value="Visiting Physician" onclick="selectCheckbox('visiting_physician')">
                    <label for="visiting_physician">VISITING PHYSICIAN</label>
                  </div>
                  <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others" onclick="selectCheckbox('others')">
                    <label for="others">OTHERS (please specify)</label>
                    <input class="others col-sm-2 cert others" type="text" id="others_text" name="others" value="" style="text-transform:capitalize" disabled >
                  </div> 
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-3">
                        <label for="last_name" style="font-size:13px;">Name</label>
                        <div class="form-group">
                          <label for="last_name">Last Name</label>
                          <input type="text" class="form-control lastname" value="{{utf8_decode($view->LastName)}}" name="lastname"id="last_name" readonly>
                        </div>
                      </div> 
                      <div class="col-sm-3">
                        <div class="form-group"><br>
                          <label for="first_name">First Name</label>
                          <input type="text" class="form-control firstname" value="{{utf8_decode($view->FirstName)}}"  name="firstname"id="first_name" readonly>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group"><br>
                          <label for="middle_name">Middle Name</label>
                          <input type="text" class="form-control middlename" value="{{utf8_decode($view->MiddleName)}}" name="middlename" id="middle_name" readonly>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-group"><br>
                          <label for="age">Age</label>
                          <input type="number" class="form-control age" value="{{$age}}" name="age" id="age" readonly>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group"><br>
                          <label for="age">Gender</label>
                          <input type="text" class="form-control gender" value="{{$newgender}}" name="gender" id="gender" readonly>  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-4">
                        <label for="last_name" style="font-size:13px;">Guardian</label>
                        <div class="form-group">
                          <label for="last_name">Complete Name</label>
                          <input type="text" class="form-control guardian" value="{{$view->EC_name}}" name="guardian" id="guardian" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group"><br>
                          <label for="first_name">Contact NO</label>
                          <input type="text" class="form-control g_ContactNo" value="{{$view->EC_contactNo}}"  name="g_ContactNo"id="g_ContactNo" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group"><br>
                          <label for="middle_name">Complete Address</label>
                          <input type="text" class="form-control g_Address" value="{{$view->EC_brgy}}, {{$view->EC_city}}, {{$view->EC_province}}" name="g_Address" id="g_Address" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                         <label for="address">Contact No</label>
                         <input type="text" class="form-control course" value="{{$view->ContactNo}}" name="ContactNo" id="course" readonly>
                        </div>
                       </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                         <label for="address">Course</label>
                         <input type="text" class="form-control course" value="{{$course->course_title}}" name="course" id="course" readonly>
                        </div>
                       </div>
                     <div class="col-sm-4">
                       <div class="form-group">
                        <label for="address">Year</label>
                        <input type="text" class="form-control yr" value="{{$course->StudentYear}}" name="yr" id="yr" readonly>
                       </div>
                      </div>
                     </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="address">Date of Birth</label>
                        <input type="date" class="form-control bday" value="{{$newbday}}" name="bday" id="bday" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="address">Civil Status</label>
                        <input type="text" class="form-control civil_stat" value="{{$view->civil_status}}" name="civil_stat" id="civil_stat" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="address">Nationality</label>
                        <input type="text" class="form-control nationality" value="{{$view->nationality}}" name="nationality" id="nationality" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="address">Religion</label>
                        <input type="text" class="form-control religion" value="{{$view->religion}}" name="religion" id="religion" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <label for="address" style="font-size:13px;">Home Address</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Barangay</label>
                          <input type="text" class="form-control brgy capitalize" value="{{$view->brgy}}" name="brgy" id="brgy" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">City</label>
                          <input type="text" class="form-control city capitalize" value="{{$view->city}}" name="city" id="city" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Province</label>
                          <input type="text" class="form-control province capitalize" value="{{$view->province}}" name="province" id="province" readonly>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-sm-12">
                  <label for="address" style="font-size:13px;">Boarding House Address</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Barangay<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_brgy') is-invalid @enderror" name="b_brgy" value="{{ old('b_brgy') }}" required autocomplete="b_brgy" id="b_brgy" style="text-transform:capitalize">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">City<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_city') is-invalid @enderror" name="b_city" value="{{ old('b_city') }}" required autocomplete="b_city" id="b_city" style="text-transform:capitalize">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Province<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_province') is-invalid @enderror" name="b_province" value="{{ old('b_province') }}" required autocomplete="b_province" id="b_province" style="text-transform:capitalize">
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-sm-12">
                  <div style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:<span class="text-danger">*</span></div>
                    <textarea class="form-control col-12 @error('reason') is-invalid @enderror" name="reason" value="{{ old('reason') }}" required autocomplete="reason" id="reason" rows="5" style="text-transform:capitalize"></textarea>
                </div><br>
                <div class="form-group">
                  <button type="button" class="btn btn-default btn-custom float-right button" id="cancel">Cancel</button>
                  <button type="submit" class="btn btn-primary float-right button" id="savebutton" >Save</button>
                </div> 
              </form>
            </div>
          </div>
{{-- if ends here --}}
          @elseif($role === 'Employee')
            <div class="card-body">
              <div class="table-responsive">
                <h5 style="font-weight: bold; font-style: italic;color:royalblue)"> PATIENT INFORMATION</h5>
                <form  action="/saveReferral" method="post" id="saveRefer">
                @csrf
                  <input  class="form-control id col-2" type="hidden" name="patientId" value="{{$cipher}}" id="id" >
                  <input  class="form-control " name="role" type="" value="{{$role}}" id="" hidden>  
                  <div style="text-align: right">
                    <label style="display: center; margin-right: 10px;">Date:</label>
                    <input  class="form-control date col-sm-2 course cert float-right" name="date" type="date" value="{{ date('Y-m-d') }}" id="date">
                  </div>
                  <div class="form-group col-12">
                    <div style="font-weight: 500; font-size: 15px;font-style: bold;">REFERRED TO:<span class="text-danger">*</span></div>
                    <div style="font-weight: 400; font-size: 13px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="hospital" name="referTo[]" value="Hospital" onclick="selectCheckbox('hospital')">
                      <label for="hospital">HOSPITAL</label>
                    </div>
                    <div style="font-weight: 400; font-size: 13px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="rhu" name="referTo[]" value="RHU" onclick="selectCheckbox('rhu')">
                      <label for="rhu">RHU</label>
                    </div> 
                    <div style="font-weight: 400; font-size: 13px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="visiting_physician" name="referTo[]" value="Visiting Physician" onclick="selectCheckbox('visiting_physician')">
                      <label for="visiting_physician">VISITING PHYSICIAN</label>
                    </div>
                    <div style="font-weight: 400; font-size: 13px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others" onclick="selectCheckbox('others')">
                      <label for="others">OTHERS (please specify)</label>
                      <input class="others col-sm-2 cert others" type="text" id="others_text" name="others" value="" style="text-transform:capitalize"  disabled >
                    </div> 
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-3">
                        <label for="last_name" style="font-size:13px;">Name</label>
                          <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control lastname" value="{{utf8_decode($view->lastname)}}" name="lastname"id="last_name" readonly>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group"><br>
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control firstname" value="{{utf8_decode($view->firstname)}}"  name="firstname"id="first_name" readonly>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group"><br>
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control middlename" value="{{utf8_decode($view->middlename)}}" name="middlename" id="middle_name" readonly>
                          </div>
                        </div>
                        <div class="col-sm-1">
                          <div class="form-group"><br>
                            <label for="age">Age</label>
                            <input type="number" class="form-control age" value="{{$view->age}}" name="age" id="age" readonly>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group"><br>
                            <label for="age">Gender</label>
                            <input type="text" class="form-control gender" value="{{$view->gender}}" name="gender" id="gender" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-4">
                          <label for="last_name" style="font-size:13px;">Guardian</label>
                          <div class="form-group">
                            <label for="last_name">Complete Name</label>
                            <input type="text" class="form-control lastname" value="{{$view->guardian}}" name="guardian"id="guardian" readonly>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group"><br>
                            <label for="first_name">Contact NO</label>
                            <input type="text" class="form-control firstname" value="{{$view->gContactNo}}"  name="g_ContactNo"id="first_name" readonly>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group"><br>
                            <label for="middle_name">Complete Address</label>
                            <input type="text" class="form-control middlename" value="{{$view->gAddress}}" name="g_Address" id="middle_name" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address" style="font-size:13px;">Contact No</label>
                          <input type="text" class="form-control course" value="{{$view->contactNo}}" name="ContactNo" id="course" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Course</label>
                          <input type="text" class="form-control course" value="" name="course" id="course" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Year</label>
                          <input type="text" class="form-control yr" value="" name="yr" id="yr" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="address">Date of Birth</label>
                            <input type="text" class="form-control bday" value="{{$view->bday}}" name="bday" id="bday" readonly>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="address">Civil Status</label>
                            <input type="text" class="form-control civil_stat" value="{{$view->civilStat}}" name="civil_stat" id="civil_stat" readonly>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="address">Nationality</label>
                            <input type="text" class="form-control nationality" value="{{$view->nationality}}" name="nationality" id="nationality" readonly>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="address">Religion</label>
                            <input type="text" class="form-control religion" value="{{$view->religion}}" name="religion" id="religion" readonly>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <label for="address" style="font-size:13px;">Home Address</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Barangay</label>
                          <input type="text" class="form-control brgy" value="{{$view->brgy}}" name="brgy" id="brgy" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">City</label>
                          <input type="text" class="form-control city" value="{{$view->city}}" name="city" id="city" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Province</label>
                          <input type="text" class="form-control province" value="{{$view->province}}" name="province" id="province" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <label for="address" style="font-size:13px;">Boarding House Address</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Barangay<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_brgy') is-invalid @enderror" name="b_brgy" value="{{ old('b_brgy') }}" required autocomplete="b_brgy" id="b_brgy" style="text-transform:capitalize">
                       </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">City<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_city') is-invalid @enderror" name="b_city" value="{{ old('b_city') }}" required autocomplete="b_city" id="b_city" style="text-transform:capitalize">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Province<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_province') is-invalid @enderror" name="b_province" value="{{ old('b_province') }}" required autocomplete="b_province" id="b_province" style="text-transform:capitalize">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:<span class="text-danger">*</span></div>
                      <textarea class="form-control col-12 @error('reason') is-invalid @enderror" name="reason" value="{{ old('reason') }}" required autocomplete="reason" id="reason" rows="5" style="text-transform:capitalize"></textarea>
                    </div><br>
                    <div class="form-group">
                      <button type="button" class="btn btn-default btn-custom float-right button" id="cancel">Cancel</button>
                      <button type="submit" class="btn btn-primary float-right button" id="savebutton" >Save</button>
                    </div> 
                </form>
              </div>
            </div>
          @endif
          @else
            <div class="card-panel red lighten-3"> </div>
          @endif
        </div>
      </div>
    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

//Save SWAL ALERT 
//Save SWAL ALERT 
$("#saveRefer").submit(function(e) {
    e.preventDefault();

    // Validate at least one checkbox is checked
    var checkboxes = $(this).find('[name="referTo[]"]');
    var isChecked = checkboxes.toArray().some(checkbox => checkbox.checked);

    if (!isChecked) {
        Swal.fire({
            title: 'Error',
            text: 'Please select at least one REFERRED TO.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
        return;
    }

    var form = $(this);
    var actionUrl = form.attr('action');
    var id = form.find('[name="patientId"]').val();
    var role = form.find('[name="role"]').val();

     // Disable the save button
     $("#savebutton").prop("disabled", true);
     console.log(id);

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(response){
            if (response.status == 200) {
                Swal.fire({
                    title: response['success'],
                    icon: 'success',
                    confirmButtonText: 'proceed',
                }).then((response2) => {

                   // Enable the save button after the Swal popup is closed
                    $("#savebutton").prop("disabled", false);
                    
                    if (response2.isConfirmed) {
                        console.log(response.role);
                        var role = response.role;
                        if (role === 'Student') {
                            window.location.href = "/referral-preview-slip?id=" +  encodeURIComponent(response.id) + "&role=Student";
                        } else if (role === 'Employee') {
                            window.location.href = "/referral-preview-slip?id=" + encodeURIComponent(response.id) + "&role=Employee";
                        }
                    }
                });
                console.log(response);
            }
        }
    });
});

$(document).ready(function() {
        // Iterate over each input field with the 'capitalize' class
        $('.capitalize').each(function() {
            // Get the current value and capitalize it
            var capitalizedValue = $(this).val().replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
            // Update the input field with the capitalized value
            $(this).val(capitalizedValue);
        });
    });
    
//Back button
// $(document).ready(function(){
//         $("#cancel").click(function(){
//           window.history.back();
//       })
//     })

$(document).ready(function() {
    $("#cancel").click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Information not saved. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Canceled!',
                    text: 'Your action has been canceled.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((response) => {
                    if (response.isConfirmed) {
                        window.history.back();
                    }
                });
            }
        });
    });
});

// disable text input when checkbox is unchecked
  function selectCheckbox(id) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      var othersInput = document.getElementById('others_text');
      // Uncheck all checkboxes except the selected one
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].id != id) {
              checkboxes[i].checked = false;
          }
      }
      // Enable/disable the "Others" text input field
      if (id == 'others') {
          othersInput.disabled = false;
      } else {
          othersInput.disabled = true;
          othersInput.value = '';
      }
  }


</script>
@endsection