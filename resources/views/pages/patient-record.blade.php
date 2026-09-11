@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Patient Record')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
 border: 1px solid rgb(58, 57, 57);
 border-collapse: collapse;
 padding: 1px;
  }
  input {
  outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
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
  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }

  .inline-cursor:hover {
    font-size: 15px; 
    color: #000000;
    cursor: pointer;
  }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
  }
.fixed-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    background-color: white; 
    z-index: 1000;
}
.footer-end {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: white;
    padding: 10px;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}
</style>
<style>
  @media screen {
    #printSection {
        display: none;
    }
  }
  @media print {
    body * {
      visibility:hidden;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    .printed-div{
  position: absolute;
  left: 120px;
    }
    #printSection, #printSection * {
      visibility:visible;
    }
    #printSection {
      position: absolute;;
      left:0;
      top:0;
    } 
  }
  @page {
   margin: 5mm 10mm 5mm 10mm;  
   font-family: Cambria;
   size: Auto;
   page-break-after: avoid;
 }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
<div class="row">
  <div class="col-md-10">
    <div class="row">
      <div class="col-md-12">
        <div class="card border">
          <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;height:50px; display:flex;align-items:center"><i class="fas fa-file-alt " style='font-size:15px;'></i> </div>
            <div class="card-body mt-0 p-1">
              <form action="/generate-pdf" method="get" target="_blank" class="float-right">
                <input type="hidden" name="id" value="{{ $request->id }}">
                <button type="submit" class="btn btn-primary" style="font-size: 15px; color: rgb(255, 255, 255);"> Print</button>
              </form>
              <div class="table-responsive view-all">
                <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable">
                  <thead>
                      <tr>
                        <th style="color:white;text-align:center">Action</th>
                        <th style="color:white;text-align:center">Date</th>
                        <th style="color:white;text-align:center">Purpose</th>
                        <th style="color:white;text-align:center">Chief Complaints/Findings</th>
                        <th style="color:white;text-align:center">Physiological Parameters</th>
                        <th style="color:white;text-align:center">Treatment/Recommendation</th>
                      </tr>
                    </thead>
                    <tbody id="viewAllRecord">
                      @foreach ($view as $data)
                        <tr>
                          <td style="text-align:center">
                            <div class="dropdown">
                              <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                              <div class="dropdown-menu dropdown-menu-right">
                                  @if((int) session('campus') === 1 && $data->status === 'For Doctor')
                                  <a class="dropdown-item" href="{{ route('medical.doctor-consultation', $data->id) }}"><i class="bx bx-plus-medical mr-1"></i>doctor consultation</a>
                                  @elseif((int) session('campus') === 1 && $data->status === 'For Nurse')
                                  <a class="dropdown-item" href="{{ route('medical.nurse-treatment', $data->id) }}"><i class="bx bx-check-circle mr-1"></i>complete treatment</a>
                                  @endif
                                  @if((int) session('campus') === 1 && in_array((int) $data->id, $prescriptionRecordIds, true))
                                  <a class="dropdown-item"
                                     href="{{ route('medical.doctor-prescription.saved-pdf', $data->id) }}"
                                     target="_blank">
                                    <i class="bx bx-printer mr-1"></i>print prescription
                                  </a>
                                  @endif
                                  <a class="dropdown-item viewbutton" href="#" data-role="{{$role}}" data-id="{{ $data->id }}"><i class="bx bx-edit mr-1"></i>edit</a>
                                  <a class="dropdown-item deleteButton" href="#"  data-role="{{$role}}" data-id="{{ $data->id }}"><i class="bx bx-trash mr-1"></i>delete</a>
                              </div>
                              </div>
                          </td>
                          <td style="text-align:center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                          <td>{{ implode(', ', json_decode($data->purpose)) }}</td>
                          <td>{{ $data->findings  }}</td>
                          <td>
                            {!! $data->parameters
                                ? $data->parameters
                                : "W: $data->weight <br> H: $data->height <br> Blood-Type: $data->blood_type <br> Temp: $data->temp <br> Pulse: $data->pulse <br> Res Rate: $data->res_rate <br> BP: $data->bp" !!}
                          </td>                               
                          <td>{{ $data->recommendation }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
              <div class="card-footer">
                <button type="button"  id="button" class="btn btn-secondary  float-right">Back</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card">
        <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
            @if ($data->gender === 'F' || $data->gender === 'Female')
            <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @elseif ($data->gender === 'M' || $data->gender === 'Male')
            <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @endif
        </div> 
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
          <label style="font-size: 18px;" id="id">{{$data->patientId}}</label>
          <label class="inline-cursor" id="firstname">{{utf8_decode($name->FirstName)}}</label>
        </div>
      </div>                
    </div>
    @include('modal.addMedical-Record')
    @include('modal.editMedical-Record')
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
  //Max date
  var today = new Date().toISOString().split('T')[0];
  document.getElementById('date').setAttribute('max', today);
//update for view
 $("#updateMedicalRecord").submit(function(e) {
      e.preventDefault();

      var form = $(this);
      var actionUrl = form.attr('action');

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
        }).then((response) => {
        
        if (response.isConfirmed) {
          $('#viewMedicalRecord').modal('hide')
                console.log(response); 
                location.reload();			
            }
          })
        }
        }
    });
  });

 document.getElementById("firstname").addEventListener("mouseenter", function() {
      Swal.fire({
        title: "<small>Firstname: <b>{{utf8_decode($name->FirstName)}}</b></small> <br>" +
              "<small>Middlename: <b>{{utf8_decode($name->MiddleName)}}</b></small> <br>" +
              "<small>Lastname:  <b>{{utf8_decode($name->LastName)}}</b></small>",
        icon: "info",
        showConfirmButton: false,
        allowOutsideClick: true,
        allowEscapeKey: true,
        timerProgressBar: true,
        toast: true,
        position: "top-end" 
      });
    });

    document.getElementById("firstname").addEventListener("mouseleave", function() {
    Swal.close();
});
//Modal View
 $(document).on('click', '.viewbutton', function(){
  var id = $(this).data('id');
  var role = $(this).data('role');
  console.log(id);
  console.log(role);
  
  $.ajax({
        type: 'POST',
        url: '/viewModal',
        data: { id: id, 
        role: role},

        success: function(response) {
          $('#viewMedicalRecord').modal('show');

          if (response.role === 'Student') {
          console.log(response.viewModal.id);
          $('.id').val(response.viewModal.id);
          $('.patientId').val(response.viewModal.patientId);
          $('.lastname').val(response.viewModal.LastName);
          $('.firstname').val(response.viewModal.FirstName);
          $('.middlename').val(response.viewModal.MiddleName);
          $('.fullname').val(response.viewModal.FirstName + ' ' + response.viewModal.MiddleName + ' ' + response.viewModal.LastName);

          var today = new Date();
          var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
          $('#viewDate').val(formattedDate);
          $('#viewFindings').val(response.viewModal.findings);

           $('#viewTime').val(response.viewModal.time);
           console.log(response.time);

          if (response.viewModal.parameters === null) {
            $("#Physiological").show();
            $("#Parameter").hide();

            // $('#purpose').val(response.viewModal.purpose);
            $('#weight').val(response.viewModal.weight);
            $('#height').val(response.viewModal.height);
            $('#bloodType').val(response.viewModal.blood_type);
            $('#temperature').val(response.viewModal.temp);
            $('#pulse').val(response.viewModal.pulse);
            $('#respiratoryRate').val(response.viewModal.res_rate);
            $('#bloodPressure').val(response.viewModal.bp);

        } else {
            $("#Parameter").show();
            $("#Physiological").hide();
            console.log(response.viewModal.parameters);
            $('#viewParameters').val(response.viewModal.parameters);
        }

      
      }
      else if (response.role === 'Employee'){
            console.log(response.viewModal.id)
          $('.id').val(response.viewModal.id);
          $('.lastname').val(response.viewModal.LastName);
          $('.firstname').val(response.viewModal.FirstName);
          $('.middlename').val(response.viewModal.MiddleName);
          $('.fullname').val([response.viewModal.FirstName]+' '+[response.viewModal.MiddleName]+' '+[response.viewModal.LastName]);
          
          var today = new Date();
          var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');
          $('#viewDate').val(formattedDate);
          $('#viewFindings').val(response.viewModal.findings);
            $('#viewTime').val(response.viewModal.time);

          if (response.viewModal.parameters === null) {
            $("#Physiological").show();
            $("#Parameter").hide();

            console.log(response.viewModal.weight);
            $('#purpose').val(response.viewModal.purpose);
            $('#weight').val(response.viewModal.weight);
            $('#height').val(response.viewModal.height);
            $('#bloodType').val(response.viewModal.blood_type);
            $('#temperature').val(response.viewModal.temp);
            $('#pulse').val(response.viewModal.pulse);
            $('#respiratoryRate').val(response.viewModal.res_rate);
            $('#bloodPressure').val(response.viewModal.bp);

        } else {
            $("#Parameter").show();  
            $("#Physiological").hide();

            $('#viewParameters').val(response.viewModal.parameters);
        }

  
          }

           $('#inputs-container').empty();

            const pcsList = JSON.parse(response.viewModal.OTCmedpcs || "[]");
            const descriptions = JSON.parse(response.viewModal.OTCmedDescript || "[]");

            if (Array.isArray(descriptions) && descriptions.length > 0) {
              descriptions.forEach(function (desc, index) {
                const pcs = pcsList[index] || '';

                const newInput = `
                  <div class="input-group mb-2">
                    <input type="number" class="form-control col-sm-1" name="OTCmedpcs[]" value="${pcs}" placeholder="pcs." autocomplete="off">
                    <input type="text" class="form-control col-sm-6 OTCmedDescript" name="OTCmedDescript[]" value="${desc}" placeholder="description" autocomplete="off" readonly>
                    <input type="hidden" class="form-control col-sm-6 idOTCMed" name="idOTCMed[]" value="" readonly>
                    <input type="hidden" class="form-control col-sm-6 lotOTCMed" name="lotOTCMed[]" value="" readonly >
                    <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>
                  </div>
                `;
                $('#inputs-container').append(newInput);
              });
            } else {
              const emptyInput = `
                <div class="input-group mb-2">
                  <input type="number" class="form-control col-sm-1" name="OTCmedpcs[]" placeholder="pcs." autocomplete="off" readonly>
                  <input type="text" class="form-control col-sm-6 OTCmedDescript" name="OTCmedDescript[]" placeholder="description" autocomplete="off" readonly>
                  <input type="hidden" class="form-control col-sm-6 idOTCMed" name="idOTCMed[]" readonly>
                  <input type="hidden" class="form-control col-sm-6 lotOTCMed" name="lotOTCMed[]" readonly>
                </div>
              `;
              $('#inputs-container').append(emptyInput);
            }
            $("#addNewinput").click(function() {
    var inputGroup = `
      <div class="input-group">
          <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." autocomplete="off">
          <input type="text" class="form-control col-sm-6 OTCmedDescript" style="display: inline-block;" name="OTCmedDescript[]" aria-describedby="" placeholder="description" autocomplete="off">
          <input type="hidden" class="form-control col-sm-6 idOTCMed" style="display: inline-block;" name="idOTCMed[]" autocomplete="off">
          <input type="hidden" class="form-control col-sm-6 lotOTCMed" style="display: inline-block;" name="lotOTCMed[]" autocomplete="off">
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
                            results.append('<li class="list-group-item" data-id="' + item.id + '" data-lotno="' + item.lotno + '"data-item_name="' + item.item_name + '" data-stock="' + item.item_quantity + '" data-expiration="' + item.expiration_date + '">' + item.item_name + ' ' +'(' + item.item_quantity +  'pcs.)' +'</li>');
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
    
    var lotno = $(this).data('lotno');
    console.log(lotno);
    var stock = $(this).data('stock');
    var expiration = $(this).data('expiration');
    var parentInputGroup = $(this).closest('.input-group');

    parentInputGroup.find('.OTCmedDescript').val(item_name);
    parentInputGroup.find('.idOTCMed').val(id);
    parentInputGroup.find('.lotOTCMed').val(lotno);


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

            $(document).ready(function() {
                $('input[name="purpose[]"]').prop('checked', false);

                var remarks = response.viewModal.purpose;
                console.log(remarks);

                

                $("input:checkbox[name='purpose[]']").each(function() {
                  if (remarks.includes($(this).val())) {
                    $(this).prop("checked", true);
                  }
                })
            });
                

              $('input[name="purpose[]"]').prop('checked', false);
              const remarks = response.viewModal.purpose || '';
              $("input:checkbox[name='purpose[]']").each(function() {
                if (remarks.includes($(this).val())) {
                  $(this).prop("checked", true);
                }
              });




      $('#viewRecommendation').val(response.viewModal.recommendation);

          console.log(response.viewModal.LastName);
        }
   })
 })


 //Delete
 $(document).ready(function() {
    $('.deleteButton').click(function() {
        var recordId = $(this).data('id');

        Swal.fire({
            title: 'Delete Record',
            text: 'Are you sure you want to delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
              
              $.ajax({
                  type: 'POST', 
                  data: { id: recordId},
                  url: '/delete-record',
                  success: function(response) {
                      if (response.message === 'Deleted successfully') {
                          Swal.fire('Deleted!', 'The record has been deleted.', 'success');
                          location.reload();
                      } else {
                          Swal.fire('Error!', 'Failed to delete the record.', 'error');
                      }
                  },
                  error: function() {
                      Swal.fire('Error!', 'Failed to delete the record.', 'error');
                  }
              });
            }
        });
    });
});

//Back button in View
 $(document).ready(function(){
    $("#button").click(function(){
      window.history.back();
  })
 });

 var button = document.querySelector('.disable-button');
    setTimeout(function() {
      button.disabled = true;
    }, 30 * 60 * 1000); 

//Print 
document.getElementById("btnPrint").onclick = function () {

printElement(document.getElementById("printPart"));

}

function printElement(elem) {
var domClone = elem.cloneNode(true);

var $printSection = document.getElementById("printSection");

if (!$printSection) {
    var $printSection = document.createElement("div");
    $printSection.id = "printSection";
    document.body.appendChild($printSection);
}

$printSection.innerHTML = "";
$printSection.appendChild(domClone);
window.print();
}  
 
</script>
@endsection
