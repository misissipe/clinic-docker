@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Generated Certificate')

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
  border-width: 0 0 1px;
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
</style>
<style>
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
  color: rgb(99, 175, 211); /* light blue */
  text-shadow:  5px rgba(113, 207, 238, 0.5);
  }

  .approved-status {
    color:  rgb(99, 211, 108); /* green */
    text-shadow:  5px rgba(113, 238, 121, 0.5);
  }

  .disapproved-status {
    color: rgb(211, 99, 99); /* red */
    text-shadow:  5px rgba(238, 113, 113, 0.5);
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
      position:absolute;
      left:0;
      top:0;
    }
  }
  @page {
   margin: 5mm 10mm 5mm 10mm;  
   font-family: Cambria;
   size: Auto;
 }
</style>
@endsection
{{-- page-styles --}}

@section('content')
<!-- Zero configuration table -->
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
  {{-- show-tab --}}    
                <div class="table-responsive">
                  <div class="col-12  d-flex justify-content-center" >
                    <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 450px; height: 150px;margin-right:30px">
                    <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 120px; height: 120px;">
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 15px; font-style: bold; text-align:center;color:black;">Medical Certificate</div></div>
                      <div class="class print-body">
                        <div style="text-align: right">
                          <div style="font-weight: 400; font-size: 12px;color:black;">Course:
                            <input  class="col-2 course" name="course" type="text" value="{{$response->accro}}" id="" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                          </div>
                        </div>
                        <div style="text-align: right">
                          <div style="font-weight: 400; font-size: 12px;color:black;">School Year:
                            <input  class="col-2 " name="" type="text" value="{{$addYear}}" id="" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                          </div>
                        </div><br>
                        <table class="table" style="color:black;">
                          <tr>
                            <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
                              <div style="font-weight: 650; font-size: 12px; font-style: bold;">PERSONAL INFORMATION</div>
                            </td>
                          </tr>
                          <tr >
                            <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Name:
                                  <input  class="col-10 fullname cert name=" type="text" value="{{utf8_decode($response->firstname)}} {{utf8_decode($response->middlename)}} {{utf8_decode($response->lastname)}}" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div>
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Age:
                                  <input  class="col-7 age cert" name="age" type="text" value="{{$age}}" id="age" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Date of birth:
                                  <input  class="col-7 bday cert" name="bday" type="text" value="{{ date('m-d-Y', strtotime($response->bday))}}" id="bday" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly> 
                                </div> 
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Weight:
                                  <input  class="col-7 weight cert" name="weight" type="text" value="{{$response->weight}}" id="weight" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div> 
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Height:
                                  <input  class="col-7 height cert" name="height" type="text" value="{{$response->height}}" id="height" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div> 
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Blood Type:
                                  <input  class="col-5 bloodtype cert" name="bloodtype" type="text" value="{{$response->bloodtype}}" id="bloodtype" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div>  
                              </div>
                            </td>
                            <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                                  <div style="text-align: left">
                                    <div style="font-weight: 400; font-size: 12px;">Allergies:
                                      <input  class="col-7 allergies cert" name="allergies" type="text" value="{{$response->allergies}}" id="allergies" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                    </div> 
                                  </div>
                              </td>
                              <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Medication:
                                    <input  class="col-7 medication cert" name="medication" type="text" value="{{$response->medication}}" id="medication" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Address:
                                  <input  class="col-10 address cert" name="" type="text" value="{{$response->brgy}}, {{$response->city}} {{$response->province}}" id="address" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div> 
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Contact No.:
                                  <input  class="col-7 contactNo cert" name="" type="text" value="{{$response->contactNo}}" id="contactNo" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Temperature:
                                  <input  class="col-5 temperature cert" name="" type="text" value="{{$response->temperature}}" id="temperature" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div>
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Pulse rate:
                                  <input  class="col-5 pulse_rate cert" name="" type="text" value="{{$response->pulse_rate}}" id="pulse_rate" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div>
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Respiratory rate:
                                  <input  class="col-4 res_rate cert" name="" type="text" value="{{$response->res_rate}}" id="res_rate" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div> 
                              </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Blood Pressure:
                                  <input  class="col-5 bp cert" name="" type="text" value="{{$response->bp}}" id="bp" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly> 
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <div class="form-group row col-12 input" style="color:black;">
                          <div style="font-weight: 700; font-size: 13px; font-style: bold;">THIS IS TO CERTIFY</div>&nbsp;<div style="font-weight: 400; font-size: 13px;">that</div>
                              <input  class="text-uppercase  name " type="text" value="{{$response->firstname}} {{$response->middlename}} {{$response->lastname}}" id="name"  style="font-weight: 700; font-size: 13px; font-style: bold;text-align:center;width:75%" readonly> 
                          <div style="font-weight: 400; font-size: 13px;" >,male/female,</div>
                          <input  class=" text-uppercase  cy" type="text" value="{{$response->accro}} - {{$response->yr}}" id="cy"  style="font-weight: 600; font-size: 13px; font-style: bold;text-align:center;width:35%"readonly ><br>
                          <div style="font-weight: 400; font-size: 13px;color:black;"> was physically examined by the undersigned and was diagnosed of:</div>
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;;margin-left:80px;color:black;">
                            course & year level
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <div style="font-weight: 600; font-size: 12px; font-style: bold;color:black;">DIAGNOSIS:</div>
                            <textarea class="col-12 diagnosis "  name="recommendation" value="" id="diagnosis" rows="1" style="font-weight: 400; font-size: 12px;" readonly>{{$response->diagnosis}}</textarea>
                        </div>
                        <div class="form-group row col-12">
                        <div style="font-weight: 600; font-size: 12px; font-style: bold;color:black;">REMARKS:</div>&nbsp;&nbsp;&nbsp;
                          <textarea class="col-12 remarks"  name="recommendation" value="" id="remarks" rows="1" style="font-weight: 400; font-size: 12px;" readonly>{{$response->remarks}}</textarea>
                        </div>
                        <div class="form-group" >
                          <div class="row col-12">
                            <div style="font-weight: 700; font-size: 13px; color:black;">THIS CERTIFICATION IS ISSUED</div>&nbsp;<div style="font-weight: 400; font-size: 12px; ">upon request of the above-name student/employee as requirement for:</div>
                          </div>
                          <div style="font-weight: 400; font-size: 12px;margin-left:50px;color:black;">
                            <input class="textbox" type="checkbox" id="OJT" name="cert_issued[]" value="OJT" disabled>
                            On-The-Job Training
                            <div style="font-weight: 400; font-size: 12px;color:black;">
                            <input class="textbox" type="checkbox" id="Return for Work" name="cert_issued[]" value="Return for Work" disabled>
                            Return for Work</div> 
                            <div style="font-weight: 400; font-size: 12px;color:black;">
                            <input class="textbox" type="checkbox" id="Travel" name="cert_issued[]" value="Travel" disabled>
                            Travel</div>
                            <div style="font-weight: 400; font-size: 12px;color:black;">
                            <input class="textbox" type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity" disabled>
                            Off-campus activity</div>
                            <div style="font-weight: 400; font-size: 12px;color:black;">
                            <input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="Others" disabled>
                            Others,please specify
                            <input class="others col-sm-5 " type="text" id="others" name="others" value="{{$response->others}}" style="font-weight: 400; font-size: 12px;" readonly>
                            </div> 
                          </div><br><br>
                          <div class=" row" style="color:black;" >
                            <div class="col-sm-8">
                              <div class="form-group">
                                <input  class="col-6 " type="text" value=" {{$doctor->FirstName}} {{$doctor->MiddleName}} {{$doctor->LastName}} " id="example-text-input" style="font-weight: 400; font-size: 15px;text-align:center;" readonly>
                                <div style="font-weight: 400; font-size: 12px;">&emsp;&emsp;Signature over Printed name of Attending Physician</div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group w-50">
                                &emsp;<input  class="col-8 " type="text" value=" {{$doctor->license}}" id="example-text-input" style="font-weight: 400; font-size: 15px;text-align:center;" readonly>
                                <div style="font-weight: 400; font-size: 12px;">&emsp;&emsp;License Number</div>
                              </div>
                            </div>
                            <div class="form-group col-12 ">
                              <div style="font-weight: 400; font-size: 12px;">Date:
                                <input type="text" class="col-2"  name="recommendation" value="" id="recommendation" rows="1">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row footer-end"> <br><br>
                          {{-- <div class="col-1"></div> --}}
                          <br><br><br>
                          <div class="col-12  d-flex justify-content-end" >
                            <div class="column" style="margin-right:100px"> 
                            <br>
                             <div class="d-flex justify-content-left" style="font-size: 12px;color:black;">Doc. Code SLSU-QF-MD05</span></div>
                            <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Revision: 02</div>
                            <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Date: 08 April 2022</div>
                          </div>
                            <img src="{{asset('images/logo/sq_star.png')}}" style="width: 250px; height: 90px;margin-right:80px">
                            <img src="{{asset('images/logo/socotec.png')}}" style="width: 160px; height: 90px;margin-right:150px">
                          </div>
                        </div>
                      </div>
                  </div>
          </div>
              </div>{{-- end-tab-content--}} 
            </div>  
    </div>
  </div>
    <div class="col-md-1">
      {{-- <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(119, 241, 119); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <form action="/generatedCert"  method="post" id="generatedCert">
            @csrf
            <input  class="col-11 id" type="text" name="id" value="{{$data->id}}" id="id" hidden> 
            <input  class="col-11 " type="text" name="purpose" value="Issuance of Certificate" id="" hidden> 
            <button type="submit" class="btn btn-default button" id="generate"><a style="color: rgb(255, 255, 255); font-size: 15px;">Generated</a></button>
          </form>
        </div>
      </div> --}}
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(84, 145, 236); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <form action="/generated-medical-certificate-pdf" method="get" target="_blank" class="float-right">
            <input type="hidden" name="id" value="{{$request->id}}">
            <button type="submit" class="btn btn-primary" style="font-size: 15px; color: rgb(255, 255, 255);"> Print</button>
          </form>
        </div>
      </div>
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(75, 95, 130); height: 40px; margin-top: 0;">
        <div class="card-body">
          <button type="button" id="cancelBtnprint" class="btn btn-default button"><a style="color: rgb(255, 255, 255); font-size: 15px;">Back</a></button>
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
var id = $(this).data('id');

//Back button in View
 $(document).ready(function(){
    $("#cancelBtnprint").click(function(){
      window.history.back();
  })
 });

console.log("cet: " + "{{$response->cert_issued}}");
$(document).ready(function() {
 
 var certIssued = "{{$response->cert_issued}}";
 console.log(certIssued);
 $("input:checkbox").each(function() {
   if (certIssued.includes($(this).val())) {
     $(this).prop("checked", true);
   }
 });
});

//Print 
// document.getElementById("btnPrint").onclick = function () {
//       printElement(document.getElementById("printPart"));
//   }

//   function printElement(elem) {
//       var domClone = elem.cloneNode(true);
      
//       var $printSection = document.getElementById("printSection");
      
//       if (!$printSection) {
//           var $printSection = document.createElement("div");
//           $printSection.id = "printSection";
//           document.body.appendChild($printSection);
//       }
      
//       $printSection.innerHTML = "";
//       $printSection.appendChild(domClone);
//       window.print();
//   }  
  
  
  $("#generatedCert").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');
            var id = form.find('[name="id"]').val();
            var role = form.find('[name="role"]').val();

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
                confirmButtonText: 'okay',           
              }).then((response2) => {
              
              if (response2.isConfirmed) {
                window.history.back();
              }
            })
          } 
        }
      })
    });
</script>
@endsection