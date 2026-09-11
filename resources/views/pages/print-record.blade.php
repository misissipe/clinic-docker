@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Print Record')

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
</style>
<style>
  body {
      font-family: Arial, sans-serif;
  }
  .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
  }
  h1 {
      color: #333;
      font-size: 28px;
      margin-bottom: 20px;
  }
  p {
      font-size: 16px;
      line-height: 1.6;
  }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
<div class="row">
  <div class="col-md-12">
    <div class="card border">
      <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;height:50px; display:flex;align-items:center"><i class="fas fa-file-alt " style='font-size:15px;'></i> PATIENT RECORD</div>
        <div class="card-body mt-0 p-1">
          <div class="table-responsive view-all">
            <div id="printPart">
{{-- HEADER --}}
                <div class="print-header">
                  <div class="col-12 d-flex justify-content-center">
                      <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 450px; height: 150px; margin-right: 30px;">
                      <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 120px; height: 120px;">
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center">
                      <p style="font-size: 12px; border-bottom: 1px solid black; text-align: center; color: black;">
                        Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality
                      </p>
                    </div>
                  </div>
                </div>
{{-- FOOTER --}}
                <div class="print-footer">
                  <div class="row footer-end">
                    <div class="col-12 d-flex justify-content-end">
                        <div class="column" style="margin-right: 50px;">
                          <div class="d-flex justify-content-left" style="font-size: 20px; color: black;">Doc. Code SLSU-QF-MD03</div>
                          <div class="d-flex justify-content-left" style="font-size: 20px; color: black;">Revision: 01</div>
                          <div class="d-flex justify-content-left" style="font-size: 20px; color: black;">Date: 26 June 2020</div>
                        </div>
                          <img src="{{asset('images/logo/sq_star.png')}}" style="width: 350px; height: 128px; margin-right: 40px;">
                          <img src="{{asset('images/logo/socotec.png')}}" style="width: 260px; height: 120px; margin-right: 50px;">
                    </div>
                  </div>
                </div>
{{-- BODY --}}
                <div class="print-content">
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align: center; color: black;">
                        Patient Monitoring Record Form
                    </div>
                  </div><br><br>
                  <div class="form-group col-sm-12">
                    <div class="row">
                      Name:
                      <input class="cert lastname" type="text" value="{{ utf8_decode($name->LastName) }}" id="example-text-input" style="width: 24%; text-align: center;">&nbsp;
                      <input class="cert firstname" type="text" value="{{ utf8_decode($name->FirstName) }}" id="example-text-input" style="width: 24%; text-align: center;">&nbsp;
                      <input class="cert middlename" type="text" value="{{ utf8_decode($name->MiddleName) }}" id="example-text-input" style="width: 24%; text-align: center;">
                      Age:
                      <input class="cert age" type="text" value="{{$data->age}}" id="example-text-input" style="width: 6%; text-align: center;">
                      Gender:
                      <input class="cert gender" type="text" value="{{$data->gender}}" id="example-text-input" style="width: 10%; text-align: center;">
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic; padding: 0;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(Middle)
                    </div>
                  </div>
                </div>
                <table class="table table-sm recordTable table-bordered table-striped" id="recordTable">
                  <thead>
                    <tr>
                      <th style="color: rgb(0, 0, 0); text-align: center;">Date</th>
                      <th style="color: rgb(0, 0, 0); text-align: center;">Chief complaints/Findings</th>
                      <th style="color: rgb(0, 0, 0); text-align: center;">Physiological Parameters</th>
                      <th style="color: rgb(0, 0, 0); text-align: center;">Treatment/Recommendation/Prescription</th>
                    </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                  @foreach ($view as $data)
                    <tr>
                      <td style="text-align: center;">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                      <td>{{ $data->findings }}</td>
                      <td>{!! $data->parameters? $data->parameters: "W: $data->weight <br> H: $data->height <br> Blood-Type: $data->blood_type <br> Temp: $data->temp <br> Pulse: $data->pulse <br> Res Rate: $data->res_rate <br> BP: $data->bp" !!}</td>
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
          $('.lastname').val(response.viewModal.LastName);
          $('.firstname').val(response.viewModal.FirstName);
          $('.middlename').val(response.viewModal.MiddleName);
          $('.fullname').val(response.viewModal.FirstName + ' ' + response.viewModal.MiddleName + ' ' + response.viewModal.LastName);

          var today = new Date();
          var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
          $('#viewDate').val(formattedDate);
          $('#viewFindings').val(response.viewModal.findings);

          if (response.viewModal.parameters === null) {
            $("#Physiological").show();
            $("#Parameter").hide();  // Corrected the ID here

            console.log(response.viewModal.weight);
            $('#weight').val(response.viewModal.weight);
            $('#height').val(response.viewModal.height);
            $('#bloodType').val(response.viewModal.blood_type);
            $('#temperature').val(response.viewModal.temp);
            $('#pulse').val(response.viewModal.pulse);
            $('#respiratoryRate').val(response.viewModal.res_rate);
            $('#bloodPressure').val(response.viewModal.bp);

        } else {
            $("#Parameter").show();  // Corrected the ID here
            $("#Physiological").hide();

            $('#viewParameters').val(response.viewModal.parameters);
        }


          $('#viewRecommendation').val(response.viewModal.recommendation);
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

          if (response.viewModal.parameters === null) {
            $("#Physiological").show();
            $("#Parameter").hide();  // Corrected the ID here

            console.log(response.viewModal.weight);
            $('#weight').val(response.viewModal.weight);
            $('#height').val(response.viewModal.height);
            $('#bloodType').val(response.viewModal.blood_type);
            $('#temperature').val(response.viewModal.temp);
            $('#pulse').val(response.viewModal.pulse);
            $('#respiratoryRate').val(response.viewModal.res_rate);
            $('#bloodPressure').val(response.viewModal.bp);

        } else {
            $("#Parameter").show();  // Corrected the ID here
            $("#Physiological").hide();

            $('#viewParameters').val(response.viewModal.parameters);
        }

          $('#viewRecommendation').val(response.viewModal.recommendation);
          }

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


//update for view
 $("#updateMedicalRecord").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');

        
         var purpose = $('#purpose').val(); // Retrieve the selected purpose

        if (!purpose || purpose === "") {
          Swal.fire({
            title: 'Please select a purpose of visit',
            icon: 'warning',
            confirmButtonText: 'Okay',
          });
          return; // Prevent form submission if purpose is not selected
        } else {
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
                $('#viewtMedicalRecord').modal('hide')
                     console.log(response); 
                     location.reload();			

                 }
               })
              }
             }
           });
          }
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