@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Patient Information')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }

 input {
  outline: 0;
  border-width: 0;
  }
 .cert{
    outline: 0;
    border-width: 0 0 0px;
    border-color: rgb(58, 57, 57)
  }
  .textbox {
      transform: scale(1.5);
      margin: 10px;
      accent-color: rgb(58, 57, 57)
  }
  thead{
  background-color: rgb(110, 155, 222);
 }
 textarea  {
      outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57)
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
  .blur {
        filter: blur(1px);
    }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card" >
        <div class="card-header">
          <div class="table-responsive">
            <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PERSONAL INFORMATION</h5><br>
            <form action="/addCert"  method="post" id="saveCert">
            @csrf
            <input  class="form-control id col-2" name="patientId" type="hidden" value="{{$encryptedId}}" id="id" > 
            <input  class="form-control " name="role" type="hidden" value="{{$role}}" id="" > 
            <input  class="form-control " name="course" type="hidden" value="{{$view->course ?? ''}}" id="" > 
            <input  class="form-control " name="accro" type="hidden" value="{{$view->accro ?? ''}}" id="" > 
            <input  class="form-control " name="major" type="hidden" value="{{$view->major ?? ''}}" id="" > 
            <input  class="form-control " name="yr" type="hidden" value="{{$view->yr ?? ''}}" id=""> 
            <input  class="form-control " name="status" type="hidden" value="Approved" id=""> 
            <div class="form-group row col-12">
              <label for="example-text-input" class="" style="width: 7.9%">Name</label>
              <div class="col-3">
                <input class="form-control firstname" type="text" name="firstname" value="{{  ucwords(strtolower($view->FirstName))}}" id="example-text-input" placeholder="First Name" autocomplete="off" readonly>
              </div>
              <div class="col-2">
                <input class="form-control middlename" type="text" name="middlename" value="{{ ucwords(strtolower($view->MiddleName))}}" id="example-text-input" autocomplete="off" readonly>
              </div>
              <div class="col-2">
                <input class="form-control lastname" type="text" name="lastname" value="{{ ucwords(strtolower($view->LastName))}}" id="example-text-input" placeholder="Last Name" autocomplete="off" readonly>
              </div>
                <label for="example-search-input" class="">Age</label>
              <div class="col-1">
                <input class="form-control age" type="text" name="age" value="{{$age}}" id="example-search-input" readonly>
              </div>
              <label for="example-search-input" class="">Gender</label>
              <div class="col-2">
                <input class="form-control age" type="text" name="gender" value="{{$view->Sex}}" id="example-search-input" readonly>
              </div>
            </div>
            <div class="form-group row col-12">
            <label for="example-text-input" class="" style="width: 7.9%">Address</label>
            <div class="col-3">
              <input class="form-control brgy" type="text" name="brgy" value="{{ ucwords(strtolower($view->RBarangay ?? $view->brgy))}}" id="example-text-input" placeholder="Barangay" readonly>
            </div>
            <div class="col-3">
              <input class="form-control city" type="text" name="city" value="{{ ucwords(strtolower($view->citymunDesc ?? $view->city))}}" id="example-text-input" placeholder="City" readonly>
            </div>
            <div class="col-3">
              <input class="form-control province" type="text" name="province" value="{{ ucwords(strtolower($view->provDesc ?? $view->province))}}" id="example-text-input" placeholder="Province" readonly>
            </div>
          </div>
          <div class="form-group row col-12">
            <label for="example-tel-input" style="width: 7.9%" class="">Date of Birth</label>
            <div class="col-2">
              <input class="form-control BirthDate" type="date" name="bday" value="{{$dateofbirth ?? $newbday}}" id="BirthDate" readonly>
            </div>
              <label for="example-url-input" class="col-1">Contact No.</label>
            <div class="col-2">
              <input class="form-control contactNo" type="number" name="contactNo" value="{{$view->Cellphone ?? $view->ContactNo}}" id="example-url-input" readonly>
            </div> 
            <label for="example-password-input" class="col-1" >Weight (kg)<span class="text-danger">*</span></label>
            <div class="col-1">
              <input class="form-control weight @error('weight') is-invalid @enderror" name="weight" value="{{ $medicalrecord->weight ?? ''}}" required autocomplete="weight" type="number"  id="" autocomplete="off">
            </div>
              <label for="example-number-input" class="col-1" >Height (cm)<span class="text-danger">*</span></label>
            <div class="col-1">
              <input class="form-control @error('height') is-invalid @enderror" name="height" value="{{ $medicalrecord->height ?? ''}}" required autocomplete="height" type="number" id="" autocomplete="off">
            </div>
          </div>
            <div class="form-group row col-12">
              <label for="example-datetime-local-input" class="" style="width: 7.9%" style="text-transform:capitalize">Blood Type<span class="text-danger">*</span></label>
              <div class="col-1">
                <input class="form-control bloodtype @error('bloodtype') is-invalid @enderror" name="bloodtype" value="{{ $medicalrecord->blood_type ?? ''}}" required autocomplete="bloodtype" type="text" id="" style="text-transform:capitalize">
              </div>
                <label for="example-date-input" class="col-1">Temperature (°C)<span class="text-danger">*</span></label>
              <div class="col-1">
                <input class="form-control @error('temperature') is-invalid @enderror" name="temperature" value="{{ $medicalrecord->temp ?? ''}}" required autocomplete="temperature" type="text" id="">
              </div>
              <label for="example-month-input" class="col-1">Pulse Rate<span class="text-danger">*</span></label>
              <div class="col-1">
                <input class="form-control @error('pulse_rate') is-invalid @enderror" name="pulse_rate" value="{{ $medicalrecord->pulse ?? ''}}" required autocomplete="pulse_rate" type="text" id="">
              </div>
              <label for="example-week-input" class="col-1" style="">Respiratory Rate<span class="text-danger">*</span></label>
              <div class="col-1">
                <input class="form-control @error('res_rate') is-invalid @enderror" name="res_rate" value="{{ $medicalrecord->res_rate ?? ''}}" required autocomplete="res_rate" type="text" id="">
              </div>
              <label for="example-time-input" class="col-1">Blood Pressure<span class="text-danger">*</span></label>
              <div class="col-1">
              <input class="form-control @error('bp') is-invalid @enderror" name="bp" value="{{ $medicalrecord->bp ?? ''}}" required autocomplete="bp" type="text" id="">
              </div>
            </div>   
            <div class="form-group row col-12">
              <label for="example-time-input" class="" style="width: 7.9%">Allergies<br>(if any)</label>
              <div class="col-5">
                <input class="form-control " name="allergies" value="{{$view->al_detail}}"  type="text" id="" style="text-transform: capitalize" autocomplete="off" readonly>
              </div>
                <label for="example-time-input" class="">Medication <br> (if any)</label>
              <div class="col-5">
                <input class="form-control " name="medication" value="{{$view->med_detail}}" type="text" id="" style="text-transform: capitalize" autocomplete="off" readonly>
              </div>
            </div>
            <div class="form-group row col-12">
              <label for="example-time-input" class="" style="width: 7.9%" style="text-transform:capitalize">Diagnosis</label>
              <div class="col-5">
                <textarea class="form-control" name="diagnosis" value="" id="diagnosis" rows="5" style="text-transform: capitalize"></textarea>
              </div>
                <label for="example-time-input" class="" style="width: 4.4%" style="text-transform:capitalize">Remarks</label>
              <div class="col-5">
                <textarea class="form-control" name="remarks" value=""  id="remarks" rows="5" style="text-transform: capitalize"></textarea>
              </div>
            </div>         
            <div class="form-group">
              <div class="col-md-12 row">
                  <h6 style="font-weight:bold;">THIS CERTIFICATION IS ISSUED</h6> &nbsp; <h6> upon request of the above-name student/employee as requirement for:</h6> <span class="text-danger">*</span>
              </div>
              <input type="checkbox" id="OJT" name="cert_issued[]" value="OJT" onclick="selectCheckbox('OJT')">
              <label for="ChestPain">On-the-Job Training</label><br>
              <input type="checkbox" id="work" name="cert_issued[]" value="Return for Work" onclick="selectCheckbox('work')">
              <label for="Insomnia">Return for Work</label><br>
              <input type="checkbox" id="Travel" name="cert_issued[]" value="Travel" onclick="selectCheckbox('Travel')">
              <label for="JointPains">Travel</label><br>
              <input type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity" onclick="selectCheckbox('Off-campus Activity')">
              <label for="Dizziness">Off-campus activity</label><br>
              <input type="checkbox" id="others" name="cert_issued[]" value="Others" onclick="selectCheckbox('others')">            
              <label for="vehicle2">Others,please specify</label><br>
              <input class="form-control othersPreIll col-sm-3 others_input" type="text" id="others_input" name="others" value="" style="text-transform:capitalize" disabled>
            </div>
            <div id="spinner-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.2); z-index: 9999;">
              <div class="d-flex justify-content-center align-items-center h-100">
                <div class="spinner-border spinner-border-lg text-primary" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </div>
            <br>
            <div class="col-12">
              <button type="button" class="btn btn-default btn-custom float-right" id="cancelBtn">Cancel</button>
              <button type="submit" class="btn btn-primary btn-custom float-right " id="saveCert">Save</button><br>
            </div>
          </form>
        </div> 
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
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).ready(function() {

  function updateReadonlyStatus() {
    var brgyValue = $('#brgy-input').val();
    var cityValue = $('#city-input').val();
    var provinceValue = $('#province-input').val();

    if (brgyValue === "Please select barangay") {
        $('#brgy-input').prop('readonly', false); 
    } else if (!brgyValue || !cityValue || !provinceValue) {
        $('#brgy-input').prop('readonly', false);  
        $('#city-input').prop('readonly', false);
        $('#province-input').prop('readonly', false);
    } else {
        $('#brgy-input').prop('readonly', true);
    }
  }

  updateReadonlyStatus();

  $('#brgy-input, #address-input, #city-input, #province-input').on('change keyup', function() {
      updateReadonlyStatus();
  });
});


function selectBox(id) {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  var othersInput = document.getElementById('othersinput');
  
  if (id == 'others') {
      othersInput.disabled = false;
  } else {
    othersInput.disabled = true;
    document.getElementById('others').checked = false;
    if (id == 'OJT') {
        othersInput.value = '';
    }
    else if (id == 'Return for Work') {
        othersInput.value = '';
    }
    else if (id == 'Travel') {
        othersInput.value = '';
    }
    else if (id == 'Off-campus Activity') {
        othersInput.value = '';
    }
  }

  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].id != id) {
        checkboxes[i].checked = false;
    }
  }
}

$(document).ready(function() {
  $('.capitalize').each(function() {
    var capitalizedValue = $(this).val().replace(/\w\S*/g, function(txt) {
      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
    
    $(this).val(capitalizedValue);
  });
});


function selectCheckbox(id) {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  var othersInput = document.getElementById('others_input');

  if (id == 'others') {
    othersInput.disabled = false;
  } else {
    othersInput.disabled = true;
    othersInput.value = '';
  }

  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].id != id) {
        checkboxes[i].checked = false;
    }
  }
}
 

//Add Form / To create
$("#saveCert").submit(function (e) {
  e.preventDefault();

  var form = $(this);
  var actionUrl = form.attr('action');
  var id = form.find('[name="patientId"]').val();
  var role = form.find('[name="role"]').val();

  $("#saveCert").prop("disabled", true);
  $("#spinner-overlay").show();
  $(".blur").addClass("blur");
  console.log(id);

  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(),
    success: function (response) {

    $("#spinner-overlay").hide();
    $(".blur").removeClass("blur");

    console.log(response);
    if (response.status == 200) {
        Swal.fire({
          title: response['success'],
          icon: 'success',
          confirmButtonText: 'proceed',
        }).then((response2) => {
          if (response2.isConfirmed) {
            console.log(response.role);
            var role = response.role;
            if (role === 'Student') {
                window.location.href = "/medical-preview-certificate?id=" + encodeURIComponent(response.newID) + "&role=Student";
            } else if (role === 'Employee') {
                window.location.href = "/medical-preview-certificate?id=" + encodeURIComponent(response.newID) + "&role=Employee";
            }
          }

          $("#saveCert").prop("disabled", false);
        });
      }
    }
  });
});



$(document).ready(function() {
  $("#cancelBtn").click(function() {
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

</script>
@endsection