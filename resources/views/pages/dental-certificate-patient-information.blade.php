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
    <div class="col-8">
      <div class="card" >
        <div id="overlay"></div>
        <div class="card-header">
          <div class="table-responsive">
            <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PERSONAL INFORMATION</h5><br>
            <form action="/saveCertificate"  method="post" id="saveCert">
            @csrf
            <input  class="form-control id col-2" name="patientId" type="hidden" value="{{$request->id ?? $encryptedId}}" id="id" > 
            <input  class="form-control " name="role" type="" value="{{$role}}" id="" hidden> 
            <input  class="form-control " name="gender" type="" value="{{$newgender ?? ''}}" id="" hidden> 
            <input  class="form-control " name="purpose" type="hidden" value="Issuance of Dental Certificate" id="">  
            <input  class="form-control " name="designation" type="hidden" value="{{$view->EmploymentStatus ?? ''}}" id="" > 
            <div class="form-group row col-12">
              <label for="example-text-input" class="" style="width: 7.9%">Name</label>
              <div class="col-4">
                <input class="form-control firstname" type="text" name="firstname" value="{{ucwords(strtolower(utf8_decode($view->FirstName)))}}" id="example-text-input" placeholder="First Name" readonly>
              </div>
              <div class="col-4">
                <input class="form-control middlename" type="text" name="middlename" value="{{ucwords(strtolower(utf8_decode($view->MiddleName)))}}" id="example-text-input" readonly>
              </div>
              <div class="col-3">
                <input class="form-control lastname" type="text" name="lastname" value="{{ucwords(strtolower(utf8_decode($view->LastName)))}}" id="example-text-input" placeholder="Last Name" readonly>
              </div>
            </div>
            <div class="form-group row col-12">
              <label for="example-text-input" style="width: 7.9%">Address</label>
              <div class="col-3">
                <input class="form-control brgy capitalize" type="text" name="brgy" value="{{ucwords(strtolower(utf8_decode($view->p_street))) ?? ucwords(strtolower(utf8_decode($view->RBarangay)))}}" id="example-text-input" placeholder="Barangay" readonly>
              </div>
              <div class="col-4">
                <input class="form-control city capitalize" type="text" name="city" value="{{ucwords(strtolower(utf8_decode($view->p_municipality))) ?? ucwords(strtolower(utf8_decode($view->citymunDesc)))}}" id="example-text-input" placeholder="City" readonly>
              </div>
              <div class="col-4">
                <input class="form-control province capitalize" type="text" name="province" value="{{ucwords(strtolower(utf8_decode($view->p_province))) ?? ucwords(strtolower(utf8_decode($view->provDesc)))}}" id="example-text-input" placeholder="Province" readonly>
              </div>
            </div>
            <div class="form-group row col-12">
              <label for="example-tel-input" style="width: 7.9%" class="">Treatment<span class="text-danger">*</span></label>
              <div class="col-11">
                <input class="form-control treated_by" type="text" name="treated_by" value="" id="treated_by" autocomplete="off" required >
              </div>
            </div>
            <div class="form-group row col-12">
              <label for="example-tel-input" style="width: 7.9%" class="">No. Day/s of rest<span class="text-danger">*</span></label>
              <div class="col-5">
                <input class="form-control no_days" type="number" name="no_days" value="" id="no_days" autocomplete="off" required>
              </div>
              <label for="example-tel-input" style="width: 8.4%" class="">Date</label>
              <div class="col-5">
                  <input class="form-control BirthDate" type="date" name="date" value="{{$ldate}}" id="date" >
              </div>
            </div>
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

//Add Form / To create
$("#saveCert").submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');
    var id = form.find('[name="patientId"]').val();
    var role = form.find('[name="role"]').val();

    $("#saveCert").prop("disabled", true);
    $("#spinner-overlay").show();
    $(".blur").addClass("blur");

    $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(),
    success: function(response) {
        console.log(response);

    $("#spinner-overlay").hide();
    $(".blur").removeClass("blur");

    if (response.status == 200) {
      Swal.fire({
        title: response['success'],
        icon: 'success',
        confirmButtonText: 'proceed',
      }).then((response2) => {
        $("#saveCert").prop("disabled", false);

        if (response2.isConfirmed) {
            console.log(response.role);

            var role = response.role;

            if (role === 'Student') {
                window.location.href = "/dental-preview-certificate?id=" + encodeURIComponent(response.newID) + "&role=Student";
            } else if (role === 'Employee') {
                window.location.href = "/dental-preview-certificate?id=" + encodeURIComponent(response.newID) + "&role=Employee";
            }
          }
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