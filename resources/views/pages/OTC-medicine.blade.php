@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Over-The-Counter Medicine Create')

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
  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }

  .inline-cursor:hover {
    font-size: 16px; 
    color: #000000;
    cursor: pointer;
  }
  .pending-status {
    color: rgb(99, 175, 211);
    text-shadow:  5px rgba(113, 207, 238, 0.5);
  }
  .blur {
        filter: blur(1px);
    }

</style>
@endsection
@section('content')
<section id="basic-datatable">
  <div class="row mx-auto">
    <div class="col-md-2">
      <div class="card text-left">
        <div class="card-body">
          <div class="form-group">
            <div class="col-sm-12">
              <div style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                Choose Type:
                <select id="roleSelect" class="form-control" aria-label="Default select example">
                  <option disabled selected>-Select-</option>
                  <option value="Student">Student</option>
                  <option value="Employee">Employee</option>
                  <option value="Dependent">Dependent</option>
                </select>
              </div><br>
            
              <div id="searchContainer" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                Search:
                <input class="form-control" type="text" id="query" placeholder="Type here..." autocomplete="off">
                <ul id="results" class="list-group" style="font-size:12px;font-weight:400;"></ul>
              </div>
            </div>            
        </div>
        </div>
      </div>
    </div>
    {{-- style="display:none;" --}}
    <div class="col-md-10" id="show" style="display:none;">
      <div class="card-header" style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800;display:flex;align-items:center;">
        <i class="fa fa-id-card-o" style="font-size:30px"></i>
        <input type="text" class="cert col-sm-5 name" name="" id="firstname" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
      </div>          
      <div class="card text-left">
        <div class="card-body">
          <form action="/createOTC"  method="post" id="otcForm">
            @csrf  
              <input type="hidden" class="cert col-sm-3 fname" name="firstname" id="firstname" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
              <input type="hidden" class="cert col-sm-3 mname" name="middlename" id="middlename" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
              <input type="hidden" class="cert col-sm-3 lname" name="lastname" id="lastname" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
              <input class="form-control poscourse" type="hidden" name="poscourse" id="poscourse" >
              <input class="form-control" type="hidden" name="purpose" id="purpose" value="OTC Medicine" >
              <input class="form-control role" type="hidden" name="role" id="role" >
              <input class="form-control id" type="hidden" name="patientId" id="id" >
              <input class="form-control gender" type="hidden" name="gender" id="gender" >
              <div style="font-weight: 400; font-size: 20px;">
              <input class="form-control date col-sm-2 float-right @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" id="date" name="date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" style="display: inline-block;">
              </div> 
              <br>
            <div class="form-outline ">
              <label class="form-label" for="textAreaExample">Remarks:</label>
              <textarea class="form-control @error('OTCremarks') is-invalid @enderror" name="OTCremarks" value="{{ old('OTCremarks') }}" required autocomplete="off"  id="OTCremarks" rows="5"></textarea>
            </div><br>
            <div class="form-outline">
              <button class="btn btn-success" id="add-input" type="button">Add</button><br>
              <label class="form-label" style="display: inline-block;" for="textAreaExample">Medicine:<span class="text-danger">*</span></label>
              <div id="inputs-container">
                <div id="inputs-container">
                  <div class="input-group">
                      <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." autocomplete="off" required>
                      <input type="text" class="form-control col-sm-5 OTCmedDescript" style="display: inline-block;" name="OTCmedDescript[]" aria-describedby="" placeholder="description" autocomplete="off" required>
                      <input type="hidden" class="form-control col-sm-5 idOTCMed" style="display: inline-block;" name="idOTCMed[]">
                      <span class="text-danger stockWarning" style="display: none;"> Low stock! </span>
                      <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>
                      <span class="text-danger expirationWarning" style="display:none;"></span>
                      <ul class="list-group results" style="display: none;font-size:12px;font-weight:400;"></ul>
                      {{-- <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button> --}}
                      <br><br>
                  </div>
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
            <div class="form-group">
              <button type="button" id="cancelBtn" class="btn btn-default btn-custom float-right">Cancel</button>
              <button type="submit" class="btn btn-primary btn-custom float-right" id="saveBtn">Save</button>
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
//Max date today
// var today = new Date().toISOString().split('T')[0];
// document.getElementById('date').setAttribute('max', today);

$(document).ready(function(){
    $("#cancelBtn").click(function(){
      location.reload();
  })
 });

 $("#otcForm").submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');

    $("#saveBtn").prop("disabled", true);
    $("#spinner-overlay").show();
    $(".blur").addClass("blur");

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(),
        success: function(response) {
            $("#spinner-overlay").hide();
            $(".blur").removeClass("blur");

            console.log(response);

            if (response && response.status === 200) {
                Swal.fire({
                    title: response.success,
                    icon: 'success',
                    confirmButtonText: 'Okay',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                        $("#saveBtn").prop("disabled", false);
                    }
                });
            } else if (response.error) { 
                Swal.fire({
                    title: "Error",
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'Okay', 
                }).then((result) => {
                    $("#saveBtn").prop("disabled", false);
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
            } else {
                console.error("Unexpected response:", response);
            }
        },
        error: function(xhr, status, error) {
            $("#spinner-overlay").hide();
            $(".blur").removeClass("blur");
            $("#saveBtn").prop("disabled", false);

            Swal.fire({
                title: "AJAX Error",
                text: "Something went wrong. Please try again.",
                icon: 'error',
                confirmButtonText: 'Okay'
            });
            console.error("AJAX Error:", error);
        }
    });
});


// $(document).ready(function () {
//   $('#roleSelect').on('change', function () {
//     var selectedRole = $(this).val();

//     if (selectedRole === 'Student' || selectedRole === 'Employee') {
//       $('#searchContainer').show();
//       $('#view').hide();
//       $('#addButtonContainer').hide();
//     } else if (selectedRole === 'Dependent') {
//       $('#searchContainer').hide();
//       $('#show').hide();
//       $('#addButtonContainer').show();
//     } else {
//       $('#searchContainer').hide();
//       $('#addButtonContainer').hide();
//     }
//   });
//addbtn
$(document).on('click', '#addButtonContainer', function(){
  var today = new Date();
      var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

      $('.date').val(formattedDate);
  $("#view").removeAttr("style").hide();
    $("#view").show();
})

$('#results').hide();
$('#query').on('keyup', function () {
    var query = $(this).val();
    var role = $('#roleSelect').val();

      if (query !== '') {
        $.ajax({
          url: "{{ route('autoSearchOTC') }}",
          method: "post",
          data: { role: role, query: query },
          dataType: "json",
          success: function (data) {
            $('#results').fadeIn();
            $('#results').html('');

            $.each(data, function (index, item) {
              var middlename = item.middlename;
              console.log(middlename);
              if (middlename === null) {
                    $('#results').append('<li class="list-group-item" data-id="' + item.id + '" data-poscourse="' + item.poscourse + '" data-last_name="' + item.lastname + '" data-first_name="' + item.firstname + '" data-middle_name="' + item.middlename + '" data-gender="' + item.gender + '" data-birthdate="' + item.birthdate + '">' + item.id + '-' + (item.lastname).replace(/ï¿½\?Â±|Ã±/g, 'ñ') + ', ' + (item.firstname).replace(/ï¿½\?Â±|Ã±/g, 'ñ') + ' ' + '</li>');
                  }
              else{
                    $('#results').append('<li class="list-group-item" data-id="' + item.id + '" data-poscourse="' + item.poscourse + '" data-last_name="' + item.lastname + '" data-first_name="' + item.firstname + '" data-middle_name="' + item.middlename + '" data-gender="' + item.gender + '" data-course="' +  item.birthdate + '">' + item.id + '-' + (item.lastname).replace(/ï¿½\?Â±|Ã±/g, 'ñ') + ', ' + (item.firstname).replace(/ï¿½\?Â±|Ã±/g, 'ñ') + ' ' + (item.middlename).replace(/ï¿½\?Â±|Ã±/g, 'ñ'));
                  }
               
            });
          }
        });
      } else {
        $('#results').fadeOut();
      }
  });

  $('#results').on('click', 'li', function () {
    var role = $('#roleSelect').val();
    var today = new Date();
    var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

    var id = $(this).data('id');
    var last_name = $(this).data('last_name').replace(/ï¿½\?Â±|Ã±/g, 'ñ');
    var first_name = $(this).data('first_name').replace(/ï¿½\?Â±|Ã±/g, 'ñ');
    var middle_name = $(this).data('middle_name');
    var gender =  $(this).data('gender');
    var poscourse = $(this).data('poscourse');

    // console.log(middle_name);
    if (middle_name === null || middle_name === "null") { 
      $('.name').val(first_name + ' ' + last_name);
    } else {
      $('.name').val(first_name + ' ' + middle_name.replace(/ï¿½\?Â±|Ã±/g, 'ñ') + ' ' + last_name);
    }
     
    $('.fname').val(first_name);
    $('.mname').val( middle_name);
    $('.lname').val(last_name);
    $('.date').val(formattedDate);
    $('.role').val(role);
    $('.id').val(id);
    $('.poscourse').val(poscourse);
    $('#gender').val(gender);
    $('#query').val(id);

    $('#results').fadeOut();

    $("#show").removeAttr("style").hide();
    $("#show").show();
  });

  $('#query').on('input', function () {
    if ($(this).val() === '') {
      $("#show").hide();
    }
  });

  $(document).ready(function() {
    // Add input
    $("#add-input").click(function() {
        var inputGroup = `
            <div class="input-group">
                <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." autocomplete="off"required>
                <input type="text" class="form-control col-sm-5 OTCmedDescript" style="display: inline-block;" name="OTCmedDescript[]" aria-describedby="" placeholder="description" autocomplete="off" required>
                <input type="hidden" class="form-control col-sm-5 idOTCMed" style="display: inline-block;" name="idOTCMed[]" >
                <span class="text-danger stockWarning" style="display: none;"> Low stock! </span>
               
                <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>
                <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>
                 <span class="text-danger expirationWarning" style="display:none;"></span>
                <ul class="list-group results" style="display: none;font-size:12px;font-weight:400;"></ul>
            </div>
        `;
        $("#inputs-container").append(inputGroup);
    });

    // Remove input
    $(document).on("click", ".remove-input", function() {
        $(this).parent().remove();
    });

    $(document).on('keyup', '.OTCmedDescript', function () {
        var OTCmedDescript = $(this).val();
        var results = $(this).siblings('.results');

        if (OTCmedDescript !== '') {
            $.ajax({
                url: "/searchMed",
                method: "post",
                data: { OTCmedDescript: OTCmedDescript },
                dataType: "json",
                success: function (data) {
                    results.fadeIn();
                    results.html('');

                    if (data.length === 0) {
                        results.append('<li class="list-group-item">No records found</li>');
                    } else {
                        $.each(data, function (index, item) {
                            results.append('<li class="list-group-item" data-id="' + item.id + '" data-lotno="' + item.lotno + '"data-item_name="' + item.item_name + '" data-stock="' + item.item_quantity + '" data-expiration="' + item.expiration_date + '">' + item.item_name + ' ' +'(' + item.item_quantity + ' pcs. ' + ', ' + ' Exp.' + item.expiration_date +  ')' +'</li>');
                        });
                    }
                }
            });
        } else {
            results.fadeOut();
        }
    });

    $(document).on('click', '.results li', function () {
    var item_name = $(this).data('item_name');
    var id = $(this).data('id');
    var stock = $(this).data('stock');
    var expiration = $(this).data('expiration');
    var parentInputGroup = $(this).closest('.input-group');

    parentInputGroup.find('.OTCmedDescript').val(item_name);
    parentInputGroup.find('.idOTCMed').val(id);

    var stockWarning = parentInputGroup.find('.stockWarning');
    var stockLeft = parentInputGroup.find('.stockLeft');

    if (stock < 50) {
        stockWarning.show();
        stockLeft.text('Stock Left: ' + stock);
    } else {
        stockWarning.hide();
    }

    var expirationWarning = parentInputGroup.find('.expirationWarning');
    var expirationDate = new Date(expiration);
    var currentDate = new Date();
    var threeMonthsLater = new Date();
    threeMonthsLater.setMonth(currentDate.getMonth() + 3);

    if (expirationDate <= currentDate) {
        expirationWarning.text('Warning: Expiration Date has passed (' + expiration + ')').show();
    } else if (expirationDate <= threeMonthsLater) {
        expirationWarning.text('Warning: Expiration Date is within 3 months (' + expiration + ')').show();
    } else {
        expirationWarning.hide();
    }

    $(this).parent('.results').fadeOut();
});

});
</script>
@endsection