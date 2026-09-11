@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Set Schedule')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
 border: 1px solid rgb(58, 57, 57);
 border-collapse: collapse;
 padding: 1px;
 text-align: center;
  }

  input {
  outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  </style>
  <style>
  textarea  {
    outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  .ph-card-header
  {
      background-color: #3a76c5;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  ul
  {  
      cursor:pointer;  
  }  
  li:hover {
  background-color: rgba(220, 225, 229, 0.953);
}
</style>
@endsection
{{-- page-styles --}}

@section('content')
{{-- <div class="row">
    <div class="col-12">
        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
    </div>
</div> --}}
<!-- Zero configuration table -->
<section id="basic-datatable">
<div class="row mx-auto">
  <div class="col-md-2">
    <div class="card text-left">
      <div class="card-body" style="background-color:rgb(110, 155, 222);">
        <div class="row" >
          <div class="col-12"  style="color:#f5f2f2;font-weight:bold;font-size:14px">
            <h5 style="color:#f5f2f2;font-weight:bold;align-items:center">Other Information</h5>
            <hr>
              Course: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:18px;color:lightyellow;font-style:italic;">{{$course->accro}}</label><br>
              Major: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:18px;color:lightyellow;font-style:italic;">{{$course->course_major}}</label>
            <hr>
            <div class="form-group">
              Age: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:18px;color:lightyellow;font-style:italic;">{{$age}}</label><br>
              Gender: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:18px;color:lightyellow;font-style:italic;">{{$gender}}</label>
            <hr>
              DOB: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:18px;color:lightyellow;font-style:italic;">{{ date('m-d-Y', strtotime($newbday))}}</label><br>
              Religion: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:18px;color:lightyellow;font-style:italic;">{{$student->religion}}</label>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 " id="show">
    <div class="card-header" style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;display:flex;align-items:center;">
      <i class="fa fa-id-card-o" style="font-size:30px"></i>
      <input type="text" class="cert col-sm-10 name" name="firstname" id="name" style="background-color:transparent;color:#ffffff;font-size:20px;font-weight:500;font-style:italic" value="{{utf8_decode($student->FirstName)}} {{utf8_decode($student->MiddleName)}} {{utf8_decode($student->LastName)}}" readonly>
    </div>          
    <div class="card text-left">
      <div class="card-body">
        <form action="/setAppointmemt"  method="post" id="appointmentForm">
          @csrf  
            <input class="form-control" type="hidden" name="role" id="role" value="Student">
            <input class="form-control" type="hidden" name="patientId" id="id" value={{$course->StudentNo}}>
            <input class="form-control" type="hidden" name="status" id="Pending" value="Pending">
            <input class="form-control lastname" type="hidden" name="lastname" id="lastname" value={{$course->LastName}}>
            <input class="form-control firstname" type="hidden" name="firstname" id="firstname" value={{$course->FirstName}}>
            <input class="form-control middlename" type="hidden" name="middlename" id="middlename" value={{$course->MiddleName}}>

            <div style="font-weight: 400; font-size: 20px;">
              {{-- Name: {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}} --}}
              <div class=" col-md-12">
                <label for="purpose" style="display: inline-block;width:15%">Contact Number: </label>
                <input type="text" id="contactNo" style="display: inline-block;" class="form-control col-sm-5 @error('contactNo') is-invalid @enderror" name="contactNo" value="{{$course->ContactNo}}" required autocomplete="contactNo" />
            </div>
            <br>
            <div class=" col-md-12">
                <label for="purpose" style="display: inline-block;width:15%">Appointment: </label>
                <input type="date" id="date" style="display: inline-block;" class="form-control col-sm-5 @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" />
                <input type="time" id="time" style="display: inline-block;" class="form-control col-sm-5 @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required autocomplete="time" />
            </div>
            <br>
            <div class=" col-md-12">
                <label for="purpose" style="display: inline-block;width:15%">Purpose:</label>
                <select name="purpose" class="form-control col-sm-5" style="display: inline-block;">
                <option value="" disable selected>-Select-</option>
                <?php
                $purpose = array("Dental Check-up/Consultation", "Cavity Filling/Oral Restoration", "Oral Prophylaxis","Tooth Extration");
                foreach ($purpose as $pur) {
                    echo "<option value=\"$pur\">$pur</option>";
                }
                ?>
                </select>
            </div> <br>
          <div class="form-group">
            <button type="button" id="cancelBtn" class="btn btn-default btn-custom float-right">Cancel</button>
            <button type="submit" class="btn btn-primary btn-custom float-right">Save</button>
          </div>
        </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
    // Save SWAL ALERT
    $("#appointmentForm").submit(function(e) {
  e.preventDefault();

  var form = $(this);
  var actionUrl = form.attr('action');
  var role = $('#roleSelect').val();

  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), 
    success: function(response){
      if (response.status == 200) {
        Swal.fire({
          title: response['success'],
          icon: 'success',
          confirmButtonText: 'Okay',
        }).then((response1) => {
          if (response1.isConfirmed) {
            location.reload();
          }
        });
      } else if (response.status == 400) {
        Swal.fire({
          title: response['error'],
          icon: 'error',
          confirmButtonText: 'Okay',
        }).then((response1) => {
          if (response1.isConfirmed) {
            window.location.href ="/appointment"
          }
        });
      }
      console.log(response); 	
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
    }
  });
});

</script>
@endsection