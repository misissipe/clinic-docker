@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
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
      border-width: 0 0 1px;
      border-color: rgb(58, 57, 57);
    }
  .cert{
    outline: 0;
    border-width: 0 0 0px;
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

ul
{  
    cursor:pointer;  
}  
li:hover {
background-color: rgba(220, 225, 229, 0.953);
}

.zero-configuration td:nth-child(3):contains('pending') {
    background-color: rgb(121, 144, 221);
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
</style>
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-body mt-0 p-1">
              <div class="table-responsive">
                <div id="printThis">
                  <div class="row printed-div  d-flex justify-content-left">
                    <div class="col-xl-8 col-lg-5 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300px; height: 100px;"> </div>
                      <div class="col-xl-4 col-lg-6 col-md-7 col-sm-6"><br>
                        <div class="row">
                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div>
                        </div>
                        <div class="row">
                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">San Roque, Sogod, Southern Leyte</div>
                        </div>
                        <div class="row">
                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">Email:&nbsp; <a href="#" >president@southernleytestateu.edu.ph</a> </div>
                        </div>
                        <div class="row">
                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">Website:&nbsp; <a href="#" >www.southernleytestateu.edu.ph</a></div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 15px; font-style: bold; text-align:center">Medical Certificate</div>
                  </div>
                  <div class="class print-body">
                    <div style="text-align: right">
                      <div style="font-weight: 400; font-size: 12px;">Course:
                        <input  class="col-2 course " name="course" type="text" value="" id="course" style="font-weight: 400; font-size: 12px; font-style: bold;">
                      </div>
                    </div>
                    <div style="text-align: right">
                      <div style="font-weight: 400; font-size: 12px;">School Year:
                        <input  class="col-2 " name="" type="text" value="" id="" style="font-weight: 400; font-size: 12px; font-style: bold;">
                      </div>
                    </div> <br>
                    <table class="table">
                      <tr>
                        <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
                          <div style="font-weight: 650; font-size: 12px; font-style: bold;">PERSONAL INFORMATION</div>
                        </td>
                      </tr>
                      <tr >
                        <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Name:
                              <input  class="col-10 fullname cert name=" type="text" value="{{$view->firstname}} {{$view->middlename}} {{$view->lastname}}" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Age:
                              <input  class="col-7 age cert" name="age" type="text" value="{{$view->age}}" id="age" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Date of birth:
                              <input  class="col-7 bday cert" name="bday" type="text" value="{{ date('m-d-Y', strtotime ($view->bday))}}" id="bday" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly> 
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Weight (kg):
                              <input  class="col-7 weight cert" name="weight" type="text" value="{{$view->weight}}" id="weight" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Height (cm):
                              <input  class="col-7 height cert" name="height" type="text" value="{{$view->height}}" id="height" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div> 
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Blood Type:
                              <input  class="col-5 bloodtype cert" name="bloodtype" type="text" value="{{$view->bloodtype}}" id="bloodtype" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div>  
                          </div>
                        </td>
                        <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Allergies (if any):
                              <input  class="col-7 allergies cert" name="allergies" type="text" value="{{$view->allergies}}" id="allergies" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Medication (if any):
                              <input  class="col-7 medication cert" name="medication" type="text" value="{{$view->medication}}" id="medication" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div> 
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Address:
                              <input  class="col-10 address cert" name="" type="text" value="{{$view->brgy}}, {{$view->city}}, {{$view->province}}" id="address" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Contact No.:
                              <input  class="col-7 contactNo cert" name="" type="text" value="{{$view->contactNo}}" id="contactNo" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Temperature:
                              <input  class="col-5 temperature cert" name="" type="text" value="{{$view->temperature}}" id="temperature" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Pulse rate:
                              <input  class="col-5 pulse_rate cert" name="" type="text" value="{{$view->pulse_rate}}" id="pulse_rate" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Respiratory rate:
                              <input  class="col-4 res_rate cert" name="" type="text" value="{{$view->res_rate}}" id="res_rate" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 12px;">Blood Pressure:
                              <input  class="col-5 bp cert" name="" type="text" value="{{$view->bp}}" id="bp" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                    <div class="form-group row col-12 input">
                      <div style="font-weight: 700; font-size: 12px; font-style: bold;">THIS IS TO CERTIFY</div>&nbsp;<div style="font-weight: 400; font-size: 12px;">that</div>
                        <input  class=" text-uppercase   name " type="text" value="{{$view->firstname}} {{$view->middlename}} {{$view->lastname}}" id="name"  style="width:76.9%;font-weight: 400; font-size: 12px; font-style: bold;text-align:center" readonly>
                        <div style="font-weight: 400; font-size: 12px;" >,male/female,</div>
                        <input  class=" text-uppercase  cy" type="text" value="{{$view->courses}} - {{$view->year}} " id="cy"  style="width:35%;font-weight: 400; font-size: 12px; font-style: bold;text-align:center" readonly><div style="font-weight: 400; font-size: 12px;">physically examine by the undersigned and was diagnoised of:</div>
                        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                          &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;(course & year level)
                      </div>
                    </div>
                    <div class="form-group row col-12">
                      <div style="font-weight: 700; font-size: 12px; font-style: bold;">DIAGNOSIS:</div>
                      <textarea class="col-12 diagnosis "  name="" value="" id="diagnosis" rows="1" style="font-weight: 400; font-size: 12px;" readonly>{{$view->diagnosis}}</textarea>
                    </div>
                    <div class="form-group row col-12">
                      <div style="font-weight: 700; font-size: 12px; font-style: bold;">REMARKS:</div>
                      <textarea class="col-12 remarks"  name="" value="" id="remarks" rows="1" style="font-weight: 400; font-size: 12px;" readonly>{{$view->remarks}}</textarea>
                    </div>
                    <div class="form-group" >
                      <div class="row col-12">
                        <div style="font-weight: 700; font-size: 12px; ">THIS CERTIFICATION IS ISSUED </div>&nbsp;<div style="font-weight: 400; font-size: 12px; ">upon request of the above-name student/employee as requirement for:</div>
                      </div><br>
                      <div style="font-weight: 400; font-size: 12px;">
                        <input class="textbox" type="checkbox" id="OJT" name="cert_issued[]" value="OJT">
                        On-The-Job Training
                        <div style="font-weight: 400; font-size: 12px;">
                          <input class="textbox" type="checkbox" id="Return for Work" name="cert_issued[]" value="Return for Work">
                          Return for Work
                        </div> 
                        <div style="font-weight: 400; font-size: 12px;">
                          <input class="textbox" type="checkbox" id="Travel" name="cert_issued[]" value="Travel"> 
                          Travel
                        </div>
                        <div style="font-weight: 400; font-size: 12px;">
                          <input class="textbox" type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity">
                          Off-campus activity
                        </div>
                        <div style="font-weight: 400; font-size: 12px;">
                          <input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="Others">
                          Others, please specify
                          <input class="others col-sm-2 others" type="text" id="others" name="others" value="{{$view->others}}">
                        </div>
                      </div><br><br>
                      <div class=" row" >
                        <div class="col-sm-7">
                          <div class="form-group">
                            &nbsp;<input  class="col-6 " type="text" value="EDMUNDO R. VILLA, MD., MM" id="example-text-input" style="font-weight: 400; font-size: 12px;text-align:center">
                            <div style="font-weight: 400; font-size: 12px;">&nbsp;Signature over Printed name of Attending Physician</div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group w-50">
                            <input  class="col-8 " type="text" value="052764" id="example-text-input" style="font-weight: 400; font-size: 12px;text-align:center">
                            <div style="font-weight: 400; font-size: 12px;">&emsp;License Number</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row col-12 ">
                      <div style="font-weight: 400; font-size: 12px;">Date:
                        <input type="text" class="col-8"  name="recommendation" value="" id="recommendation" rows="1">
                      </div>
                    </div>
                  </div>
                  <div class="row footer-end"> <br><br>
                    <div class="col-lg-9 col-md-8">
                      <div class="row">
                        <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Doc. Code SLSU-QF-MD05</span></div>
                        <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">FOLLOW US HERE:</div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Revision: 02</div>
                        <div class="col-md-3 d-flex justify-content-left" style="font-size: 12px;">https://www.facebook.com/southernleytestateu/</div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Date: 08 April 2022</div>
                        <div class="col-md-3 d-flex justify-content-left" style="font-size: 12px;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3"> 
                      <img src="{{asset('images/logo/socotec.png')}}" style="width: 55%; height: 70%;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card">
        <div class="card-body">
          <div style="display: flex; flex-direction: column;">
            <form action="/approve-result" method="POST" id="pendingForm">
            @csrf
              <div style="padding-bottom: 10px">
                <button type="button" class="col-md-12 btn btn-success approve" name="status" value="approve">Approve</button>
              </div>
               <button type="button" class="col-md-12 btn btn-danger disapprove" name="status" value="disapprove">Disapprove</button><hr>
               <button type="button"  id="backBtn" class="col-md-12 btn btn-secondary  float-right">Back</button>
                <textarea id="remarks" name="stat_remarks" style="display:none;"></textarea>
                <input class="col-11 id" type="hidden" name="id" value="{{$view->id}}">
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
  var patientId = 0;
//Search-Input
 $(document).ready(function() {
  $("#submitBtn").submit(function() {
    event.preventDefault();
    var search = $('#searchInput').val();
    $.ajax({
      type:'post',
      url:'/patient-medical-record',
      data:{search:search},

      success:function(data){
        $('#myTable').html(data);   
      } 
    })
  })
 });

console.log("cet: " + "{{$view->cert_issued}}");
$(document).ready(function() {
 
 var certIssued = "{{$view->cert_issued}}";
 console.log(certIssued);
 $("input:checkbox").each(function() {
   if (certIssued.includes($(this).val())) {
     $(this).prop("checked", true);
   }
 });
});

// print
$(document).on('click', '.view', function(){
  var id = $(this).data('id'); 
  var role = $('#roleSelect').val();
    console.log(role);
    console.log(id);

  if (role === 'Student') {
    window.location.href = "/viewGeneratedCert?id=" + encodeURIComponent(id)  + "&role=Student";
  } else if (role === 'Employee') {
    window.location.href = "/viewGeneratedCert?id=" + encodeURIComponent(id)  + "&role=Employee";
  }
 });

//Cancel button in Add
 $(document).ready(function(){
    $("#backBtn").click(function(){
      window.location.href = "/view-generated-certificate";
  })
 });

//
$(document).ready(function() {
  $('.approve').click(function() {
    var id = $('.id').val();
    console.log(id);
    var status = $(this).val();

    $.ajax({
        url: "/approve-result",
        type: "POST",
        data: {
            id: id,
            status: status,
        },
        success: function(response) {
          if (response.success) {
            swal.fire({
                title: "Success",
                text: response.success,
                icon: "success",
                button: "OK",
              }).then(() => {
              window.history.back();
            });
          } else if (response.error) {
              alert(response.error);
          }
        },
        error: function(xhr) {
            alert("An error occurred: " + xhr.status + " " + xhr.statusText);
        }
      });
    });

    $('.disapprove').click(function() {
    var id = $('#id').val();
    var status = $(this).val();

    swal.fire({
        title: "Disapprove",
        text: "Please enter remarks:",
        input: 'textarea',
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              resolve();
            } else {
              reject('Remarks are required.');
            }
          });
        }
    }).then(function (remarks) {
        if (remarks.value) {
          $.ajax({
            url: "/approve-result",
            type: "POST",
            data: {
                id: id,
                status: status,
                stat_remarks: remarks.value,
            },
            success: function(response) {
              if (response.success) {
                  swal.fire({
                    title: "Success",
                    text: response.success,
                    icon: "success",
                    button: "OK",
                  }).then(() => {
                    window.history.back();
                  });
                      
              } else if (response.error) {
                  alert(response.error);
              }
            },
            error: function(xhr) {
                alert("An error occurred: " + xhr.status + " " + xhr.statusText);
            }
          });
        }
    }).catch(swal.noop);
  });
});


</script>
@endsection
