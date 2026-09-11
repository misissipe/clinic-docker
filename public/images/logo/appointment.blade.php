@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Appointment')

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
        <div class="card-body">
          <div class="form-group">
            <div class="col-sm-12">
              <div style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                Choose type:
                <select id="roleSelect" class="form-control" aria-label="Default select example">
                    <option selected>-Select Role-</option>
                    <option value="Student">Student</option>
                    <option value="Employee">Employee</option>
                </select>
              </div>
              <br>
              <div style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                Search:
                <input class="form-control" type="text" id="query" placeholder="Type here...">
                <ul id="results" class="list-group" style="display: none;font-size:12px;font-weight:400;"></ul>
              </div>
          </div>
        </div>
        </div>
      </div>
    </div>
    <div class="col-md-8" id="show" style="display:none;">
      <div class="card-header" style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;display:flex;align-items:center;">
        <i class="fa fa-id-card-o" style="font-size:30px"></i>
        <input type="text" class="cert col-sm-10 name" name="firstname" id="name" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
      </div>          
      <div class="card text-left">
        <div class="card-body">
          <form action="/setAppointmemt"  method="post" id="appointmentForm">
            @csrf  
              <input class="form-control" type="hidden" name="role" id="role" >
              <input class="form-control" type="hidden" name="patientId" id="id" >
              <input class="form-control" type="hidden" name="status" id="Pending" value="Pending">
              <input class="form-control lastname" type="hidden" name="lastname" id="lastname">
              <input class="form-control firstname" type="hidden" name="firstname" id="firstname">
              <input class="form-control middlename" type="hidden" name="middlename" id="middlename">
              <div style="font-weight: 400; font-size: 20px;">
                <div class=" col-md-12">
                  <label for="purpose" style="display: inline-block;width:15%">Contact Number: </label>
                  <input type="text" id="contactNo" style="display: inline-block;" class="form-control col-sm-5 @error('contactNo') is-invalid @enderror" name="contactNo" value="{{ old('contactNo') }}" required autocomplete="contactNo" />
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
                <div class="form-check col-sm-5" style="width: 50%;margin-left:130px">
                  <input type="checkbox" id="" name="purpose[]" value="Consultation">
                  <label for="cancer" style="text-transform: capitalize;font-size:12px;">Dental Check-up/ Consultation</label>
                </div>
                <div class="form-check" style="width: 50%;margin-left:130px">
                  <input type="checkbox" id="" name="purpose[]" value="Oral Restoration">
                  <label for="cancer" style="text-transform: capitalize;font-size:12px;">Cavity Filling/ Oral Restoration</label>
                </div>
                <div class="form-check" style="width: 50%;margin-left:130px">
                  <input type="checkbox" id="" name="purpose[]" value="Oral Prophylaxis">
                  <label for="cancer" style="text-transform: capitalize;font-size:12px;">Oral Prophylaxis</label>
                </div>
                <div class="form-check" style="width: 50%;margin-left:130px">
                  <input type="checkbox" id="" name="purpose[]" value="Tooth Extraction">
                  <label for="cancer" style="text-transform: capitalize;font-size:12px;">Tooth Extraction</label>
                </div>
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

  // Check if at least one checkbox is checked
  if ($("input[name='purpose[]']:checked").length === 0) {
    // If no checkbox is checked, show an error message or handle it accordingly
    Swal.fire({
      title: 'Please select at least one purpose.',
      icon: 'error',
      confirmButtonText: 'Okay',
    });
    return;
  }

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
            // location.reload();
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


// Search
$(document).ready(function () {
    $('#query').keyup(function () {
      var query = $(this).val();
      var role = $('#roleSelect').val();

      if (role === 'Student' || role === 'Employee') {
        if (query !== '') {
          $.ajax({
            url: "{{ route('autocompleteInfo') }}",
            method: "post",
            data: {role: role, query: query},
            dataType: "json",
            success: function (data) {
              $('#results').fadeIn();
              $('#results').html('');

              if (data.length === 0) {
              $('#results').append('<li class="list-group-item">No records found</li>');
            } else {
              $.each(data, function (index, item) {
                if (role === 'Student') {
                  var middleName = item.MiddleName;
                  if (middleName === null) {
                    $('#results').append('<li class="list-group-item" data-id="' + item.StudentNo + '" data-last_name="' + item.LastName + '" data-first_name="' + item.FirstName + '" data-middle_name="' + item.MiddleName + '" data-gender="' + item.Sex + '" data-ContactNo="' + item.ContactNo + '">' + item.StudentNo + '-' + decodeURIComponent(escape(item.LastName)) + ', ' + decodeURIComponent(escape(item.FirstName)) + ' ' + '</li>');
                  }
                  $('#results').append('<li class="list-group-item" data-id="' + item.StudentNo + '" data-last_name="' + item.LastName + '" data-first_name="' + item.FirstName + '" data-middle_name="' + item.MiddleName + '" data-gender="' + item.Sex + '" data-ContactNo="' + item.ContactNo + '">' + item.StudentNo + '-' + decodeURIComponent(escape(item.LastName)) + ', ' + decodeURIComponent(escape(item.FirstName)) + ' ' + decodeURIComponent(escape(item.MiddleName)) + '</li>');
                } else if (role === 'Employee') {
                  $('#results').append('<li class="list-group-item" data-empNo="' + item.AgencyNumber + '" data-lastname="' + item.LastName + '" data-firstname="' + item.FirstName + '" data-middlename="' + item.MiddleName + '" data-gender="' + item.gender + '" data-contactNo="' + item.contactNo + '">' + item.AgencyNumber + '-' + item.lastname + ', ' + item.firstname + ' ' + item.middlename + '</li>');
                }
              });
              }
            }
            });
          } else {
             $('#results').fadeOut();
          }
        } else {
          $('#results').fadeOut();
        }
      });

    $('#results').on('click', 'li', function () {
      var role = $('#roleSelect').val();
      var today = new Date();
      var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

      if (role === 'Student') {
        var id = $(this).data('id');
        var last_name = $(this).data('last_name');
        var first_name = $(this).data('first_name');
        var middle_name = $(this).data('middle_name');
        var gender = $(this).data('gender');
        var ContactNo = $(this).data('contactno');

        $('.name').val(first_name + ' ' + middle_name + ' ' + last_name);
        $('.firstname').val(first_name);
        $('.middlename').val(middle_name);
        $('.lastname').val(last_name);
        $('.date').val(formattedDate);
        $('#role').val(role);
        $('#id').val(id);
        $('#gender').val(gender);
        $('#contactNo').val(ContactNo);
        $('#query').val(id);
         console.log(ContactNo);
      } else if (role === 'Employee') {
        var empNo = $(this).data('empno');
        var lastname = $(this).data('lastname');
        var firstname = $(this).data('firstname');
        var middlename = $(this).data('middlename');
        var gender = $(this).data('gender');
        var contactNo = $(this).data('contactno');
        console.log(gender);

        $('.name').val(firstname + ' ' + middlename + ' ' + lastname);
        $('.firstname').val(firstname);
        $('.middlename').val(middlename);
        $('.lastname').val(lastname);
        $('.date').val(formattedDate);
        $('#role').val(role);
        $('#id').val(empNo);
        $('#gender').val(gender);
        $('#contactNo').val(contactNo);
        $('#query').val(empNo);
      }
      $('#results').fadeOut();

      $("#show").removeAttr("style").hide();
      $("#show").show();
    });
   
    $('#query').on('input', function () {
      if ($(this).val() === '') {
        $("#show").hide();
      }
    });
  });


  $(document).ready(function(){
    $("#cancelBtn").click(function(){
      location.reload();
  })
 });
</script>
@endsection