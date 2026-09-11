@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','New Record')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
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
 .blur {
        filter: blur(1px);
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row mx-auto">
    <div class="col-md-8" id="show">
      <div class="card-header" style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;display:flex;align-items:center;">
        <i class="fa fa-id-card-o" style="font-size:30px"></i>
        <input type="text" class="cert col-sm-10 name" name="firstname" value="{{$data->FirstName}} {{$data->MiddleName}} {{$data->LastName}}" id="name" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
      </div>          
      <div class="card text-left">
        <div class="card-body">
          <form action="/addRecord"  method="post" id="saveTab">
            @csrf  
              <input class="form-control" type="hidden" name="role" value="{{$role}}" id="role" >
              <input class="form-control" type="hidden" name="patientId" value="{{$id}}" id="id" >
              <input class="form-control" type="hidden" name="gender" value="{{$data->Sex}}" id="gender" >
              <input class="form-control" type="hidden" name="positioncourse" value="{{$data->positioncourse}}" id="positioncourse" >
              <input class="form-control" type="hidden" name="age" value="{{$age}}" id="age" >
              <input class="form-control" type="hidden" name="year" value="{{$year}}" id="year" >
                <input class="form-control date col-sm-2 float-right @error('date') is-invalid @enderror" name="date" value="{{ old('date', \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('Y-m-d')) }}" required autocomplete="date" type="date" id="date" name="date" max="{{ \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('Y-m-d') }}" style="display: inline-block;">
              <br><div style="font-weight: 400; font-size: 20px;">
              <label for="purpose" style="display: inline-block;">Purpose of Visit:<span class="text-danger">*</span></label>
              <div class="row">
              <div class="form-check col-md-3" >
            <input type="checkbox" id="Consultation" name="purpose[]" value="Consultation">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Consultation</label>
          </div>
          <div class="form-check col-md-3">
            <input type="checkbox" id="WD" name="purpose[]" value="Wound Dressing">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Wound Dressing</label>
          </div>
          <div class="form-check col-md-3">
            <input type="checkbox" id="BP" name="purpose[]" value="Blood Pressure">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Blood Pressure</label>
          </div>
          
              </div>
         <div class="row">
          <div class="form-check col-md-3">
            <input type="checkbox" id="PC" name="purpose[]" value="Provision of Comfort">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Provision of Comfort</label>
          </div>
          <div class="form-check col-md-3">
            <input type="checkbox" id="OM" name="purpose[]" value="OTC Medicine">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">OTC Medicine</label>
          </div>
            <div class="form-check col-md-3">
            <input type="checkbox" id="PA" name="purpose[]" value="Physical Assessment">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Physical Assessment</label>
          </div>
           
         </div>
         <div class="row">
          <div class="form-check col-md-3">
            <input type="checkbox" id="OC" name="purpose[]" value="Other Concerns">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Other Concerns</label>
          </div>
            <div class="form-check col-md-3">
            <input type="checkbox" id="IC" name="purpose[]" value="Issuance of Certificate">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Issuance of Certificate</label>
          </div>
            <div class="form-check col-md-3">
            <input type="checkbox" id="Ref" name="purpose[]" value="Referral">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Referral</label>
          </div>
         </div>
            </div> 
            <br>
            <div class="form-outline ">
              <label class="form-label" for="textAreaExample">Chief Complain/Findings:<span class="text-danger">*</span></label>
              <textarea class="form-control @error('findings') is-invalid @enderror" name="findings" value="{{ old('findings') }}" required autocomplete="findings"  id="findings" rows="3"></textarea>
            </div>
            <div class="form-outline" id="Physiological" >
              <label class="form-label" for="textAreaExample">Physiological Parameters:</label>
            <div class="form-inline">
              <label class="form-label col-md-2" for="weight">Weight (KG):</label>
              <input class="form-control col-md-1" type="number" id="weight" placeholder="" name="weight" step="any" autocomplete="off">
          
              <label class="form-label col-md-2" for="height">Height (CM):</label>
              <input class="form-control col-md-1" type="number" id="height" placeholder="" name="height" step="any" autocomplete="off">
          
              <label class="form-label col-md-2" for="bloodType">Blood Type:</label>
              <input class="form-control col-md-1" type="text" id="bloodType" placeholder="" name="bloodType" step="any" autocomplete="off">
          
              <label class="form-label col-md-2" for="temperature">Temperature:</label>
              <input class="form-control col-md-1" type="number" id="temperature" placeholder="" name="temperature" step="any" autocomplete="off">
          </div><br>
          <div class="form-inline">
              <label class="form-label col-md-2" for="pulse">Pulse:</label>
              <input class="form-control col-md-1" type="number" id="pulse" placeholder="" name="pulse" step="any" autocomplete="off">
          
              <label class="form-label col-md-2" for="respiratoryRate">Respiratory Rate:</label>
              <input class="form-control col-md-1" type="number" id="respiratoryRate" placeholder="" name="respiratoryRate" step="any" autocomplete="off">
          
              <label class="form-label col-md-2" for="bloodPressure">Blood Pressure:</label>
              <input class="form-control col-md-1" type="text" id="bloodPressure" placeholder="" name="bloodPressure" autocomplete="off">
          </div>
            </div>
            <div class="form-outline">
              <label class="form-label " for="textAreaExample">Treatment/Recommendations:</label>
              <textarea class="form-control" name="recommendation" value="" id="recommendation" rows="3" ></textarea>
            </div>
            <br>
            <div class="form-outline" id="medicineOTC">
              <button class="btn btn-success" id="addNewinput" type="button">Add</button><br>
              <label class="form-label" style="display: inline-block;" for="textAreaExample">Medicine:<span class="text-danger">*</span></label>
              <div id="inputs-container">
                <div class="input-group">
                    <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." autocomplete="off">
                    <input type="text" class="form-control col-sm-4 OTCmedDescript" style="display: inline-block;" name="OTCmedDescript[]" aria-describedby="" placeholder="description" autocomplete="off">
                    <input type="hidden" class="form-control col-sm-4 idOTCMed" style="display: inline-block;" name="idOTCMed[]" autocomplete="off">
                    <input type="hidden" class="form-control col-sm-4 lotOTCMed" style="display: inline-block;" name="lotOTCMed[]" autocomplete="off">
                    <span class="text-danger stockWarning" style="display: none;"> Low stock! </span>
                    <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>&emsp;
                    <span class="text-danger expirationWarning" style="display:none;"></span>
                    <ul class="list-group results" style="display: none;font-size:12px;font-weight:400;"></ul>
                    {{-- <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button> --}}
                    <br><br>
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
              <button type="submit" id="saveBtn" class="btn btn-primary btn-custom float-right">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
      <div class="col-md-4">
      <div class="card text-left">
        <div class="card-body" style="font-size:12px">
        <label for="purpose" style="display: inline-block;font-size:20px">PREVIOUS CONSULTATION</label>
         <div class=" view-all">
                <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable">
                  <thead>
                      <tr>
                        <th style="color:white;text-align:center">Date</th>
                        <th style="color:white;text-align:center">Purpose</th>
                        <th style="color:white;text-align:center">Findings</th>
                        <th style="color:white;text-align:center">Parameters</th>
                        <th style="color:white;text-align:center">Treatment</th>
                      </tr>
                    </thead>
                    <tbody id="viewAllRecord">
                      @foreach ($view as $data)
                        <tr>
                          <td style="text-align:center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                          <td>{{ implode(', ', json_decode($data->purpose)) }}</td>
                          <td>{{ $data->findings  }}</td>
                          <td style="text-align:left">
                            {!! $data->parameters
                                ? $data->parameters
                                : "W: $data->weight <br> H: $data->height <br> B-Type: $data->blood_type <br> Temp: $data->temp <br> Pulse: $data->pulse <br> Res Rate: $data->res_rate <br> BP: $data->bp" !!}
                          </td>                               
                          <td>{{ $data->recommendation }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
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
  var patientId = 0;

//Search-Input
 $(document).ready(function() {
  $("#submitBtn").submit(function() {
     event.preventDefault();
    var search = $('#searchInput').val();
         $.ajax({
            type:'post',
            url:'/patient-monitoring-record',
            data:{search:search},

            success:function(data){
              $('#myTable').html(data);   
            } 
         })
       })
 });


 
$(document).ready(function() {
  $("#medicineOTC").hide();

  $("input[name='purpose[]']").change(function() {

    if ($("#OM").is(":checked")) {
      $("#medicineOTC").show();
    } else {
      $("#medicineOTC").hide();
    }
  });
});


document.addEventListener('click', function(e) {
   if (e.target && e.target.classList.contains('remove-input')) {
      const inputGroup = e.target.closest('.input-group');
      inputGroup.remove();
    }
});

// CANCEL
 $(document).ready(function(){
        $("#cancelBtn").click(function(){
        window.location.href = "/patient-monitoring-search"
      })
})

// Save SWAL ALERT
$("#saveTab").submit(function(e) {
  e.preventDefault();

  var form = $(this);
  var actionUrl = form.attr('action');
  var selectedPurposes = $('input[name="purpose[]"]:checked');

  if (selectedPurposes.length === 0) {
    Swal.fire({
      title: 'Please select at least one purpose of visit',
      icon: 'warning',
      confirmButtonText: 'Okay',
    });
    return;
  } else {

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

        if (response.status == 200) {
          Swal.fire({
            title: response['success'],
            icon: 'success',
            confirmButtonText: 'Okay',
          }).then((response1) => {

            alert(response.purpose.includes("Issuance of Certificate"));

          if (response.purpose.includes("Issuance of Certificate")) {
            if (response.role === 'Student') {
              window.location.href = "/medical-certificate-patient-information?id=" + encodeURIComponent(response.newId) + "&role=Student&recId=" + response.recId;
            } else if (response.role === 'Employee') {
              window.location.href = "/medical-certificate-patient-information?id=" + encodeURIComponent(response.newId) + "&role=Employee&recId=" + response.recId;
            }
          } else if (response.purpose.includes("Referral")) {
              if (response.role === 'Student') {
                  window.location.href = "/referral-patient-information?id=" + encodeURIComponent(response.newId) + "&role=Student&recId=" + response.recId;
                } else if (response.role === 'Employee') {
                  window.location.href = "/referral-patient-information?id=" + encodeURIComponent(response.newId) + "&role=Employee&recId=" + response.recId;
                }
          } else {
              if (response1.isConfirmed) {
                
               location.reload();
              }
              $("#saveBtn").prop("disabled", false);
          }
          });
          
          console.log(response);
        } else if (response.error == 'Duplicate') {
          Swal.fire({
            title: response['error'],
            icon: 'error',
            confirmButtonText: 'Okay', 
          }).then((response) => {
            $("#saveBtn").prop("disabled", false);

            if (response.isConfirmed) {
              window.history.back();
            }
          });
        }
        else if (response && response.Error === 1) {
      Swal.fire({
        icon: "error",
        title: response.Message,
      }).then((result1) => {
        if (result1.isConfirmed) {
            $("#saveBtn").prop("disabled", false);
                    }
        });
      }
      }
    });
  }
});

          
$(document).ready(function() {
    // Add input
    $("#addNewinput").click(function() {
        var inputGroup = `
            <div class="input-group">
                <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." autocomplete="off">
                <input type="text" class="form-control col-sm-4 OTCmedDescript" style="display: inline-block;" name="OTCmedDescript[]" aria-describedby="" placeholder="description" autocomplete="off">
                <input type="hidden" class="form-control col-sm-4 idOTCMed" style="display: inline-block;" name="idOTCMed[]" autocomplete="off">
                <input type="hidden" class="form-control col-sm-4 lotOTCMed" style="display: inline-block;" name="lotOTCMed[]" autocomplete="off">
                <span class="text-danger stockWarning" style="display: none;"> Low stock! </span>
               
                <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>
                <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>
                <span class="expirationWarning" style="display:none;"></span>
                <ul class="list-group results" style="display: none;font-size:12px;font-weight:400;"></ul>
            </div>
        `;
        $("#inputs-container").append(inputGroup);
    });

    $(document).on("click", ".remove-input", function() {
        $(this).parent().remove();
    });

    $(document).on('keyup', '.OTCmedDescript', function () {
        var OTCmedDescript = $(this).val();
        var results = $(this).siblings('.results');

        if (OTCmedDescript !== '') {
            $.ajax({
                url: "/searchItems",
                method: "post",
                data: { OTCmedDescript: OTCmedDescript },
                dataType: "json",
                success: function (data) {
                  console.log(data);
                    results.fadeIn();
                    results.html('');

                    if (data.length === 0) {
                        results.append('<li class="list-group-item">No records found</li>');
                    } else {
                        $.each(data, function (index, item) {
                          console.log(item);
                            results.append('<li class="list-group-item" data-id="' + item.id + '" data-lotno="' + item.lotno + '"data-item_name="' + item.item_name + '" data-stock="' + item.item_quantity + '" data-expiration="' + item.expiration_date + '">' + item.item_name + '</li>');
                        });
                    }
                }
            });
        } else {
            results.fadeOut();
        }
    });

    // Handle selection from dynamic results
    $(document).on('click', '.results li', function () {
    var item_name = $(this).data('item_name');  
    var id = $(this).data('id');
    var lotno = $(this).data('lotno');
    var stock = $(this).data('stock');
    var expiration = $(this).data('expiration');
    var parentInputGroup = $(this).closest('.input-group');

    parentInputGroup.find('.OTCmedDescript').val(item_name);
    parentInputGroup.find('.idOTCMed').val(id);
    parentInputGroup.find('.lotOTCMed').val(lotno);

    // Show the stock left
    var stockWarning = parentInputGroup.find('.stockWarning');
    var stockLeft = parentInputGroup.find('.stockLeft');

    if (stock < 50) {
        stockWarning.show();
        stockLeft.text('Stock Left: ' + stock);
    } else {
        stockWarning.hide();
    }

    // Expiration date notification
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