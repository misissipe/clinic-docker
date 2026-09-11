
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Generated Slip')

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
  border-width: 0 0 0px;
  }
 .cert{
    outline: 0;
    border-width: 0 0 1px;
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
</style>
@endsection
{{-- page-styles --}}
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
                  <div class="col-12  d-flex justify-content-center" >
                    @php
                    $campus_code = session('campus');
                    @endphp
                    @if($campus_code == 1)<img class="logo" src="images/logo/main-campus-logo.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 2)<img class="logo" src="images/logo/maasin-logo.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 3)<img class="logo" src="images/logo/tomas-oppus.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 4)<img class="logo" src="images/logo/bontoc.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 5)<img class="logo" src="images/logo/san-juan.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 6)<img class="logo" src="images/logo/hinunangan.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 80px; height: 80px;">
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                          <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center;color:black;">Referral Slip</div>
                  </div>
                  <div class="col-sm-12" style="text-align: right;color:black;">
                          Course:
                          <input  class="course cert " name="" type="text" value="{{$response->course}}" id="course" style="width:10%" readonly>
                  </div>
                  <div class="col-sm-12" style="text-align: right;color:black;">
                          School Year:
                          <input  class="cert" name="" type="text" value="{{$addYear}}" id="fullname" style="width:10%" readonly>
                  </div><br>
                  <div class="col-sm-12" style="text-align: right;color:black;">
                          Date:
                          <input  class=" date cert " name="date" type="text" value="{{date('m-d-Y', strtotime($response->date))}}" id="date" style="width:10%" readonly>
                  </div>
                  <div class="form-group col-12" style="color:black;">
                    <div class="row" style="font-weight: 600; font-size: 15px;font-style: bold;">
                          REFERRED TO:
                    </div> 
                    <div style="font-weight: 400; font-size: 12px;margin-left:85px">
                          <input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                          HOSPITAL 
                    </div>
                    <div style="font-weight: 400; font-size: 12px;margin-left:85px">
                          <input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                          RHU
                    </div> 
                    <div style="font-weight: 400; font-size: 12px;margin-left:85px">
                          <input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                          VISITING PHYSICIAN
                    </div>
                    <div style="font-weight: 400; font-size: 12px;margin-left:85px">
                          <input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others">
                          OTHERS,(please specify)
                          <input class="others col-sm-2 cert" type="text" id="others" name="others" value="{{$response->others}}" readonly >
                        </div> 
                  </div>
                  <div class="form-group col-sm-12" style="color:black;">
                    <div class="row"> 
                        Name:
                        <input  class=" cert lastname" type="text" value="{{ ucwords(strtolower(utf8_decode($response->lastname)))}}" id="lastname" style="width:21%; text-align:center" readonly>&nbsp;
                        <input  class=" cert firstname" type="text" value="{{ ucwords(strtolower(utf8_decode($response->firstname)))}}" id="firstname" style="width:20%; text-align:center" readonly>&nbsp;
                        <input  class=" cert middlename" type="text" value="{{ ucwords(strtolower(utf8_decode($response->middlename)))}}" id="middlename" style="width:20%; text-align:center" readonly>
                        Age:
                        <input  class="cert age" type="text" value="{{$response->age}}" id="age" style="width:9.5%;text-align:center" readonly>
                        Gender:
                        <input  class=" cert gender" type="text" value="{{$response->gender}}" id="gender" style="width:15.4%;text-align:center" readonly>
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;" readonly>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(Middle)
                      </div>
                    </div>
                    <div class="row">
                      Date of Birth:
                      <input  class=" cert bday" type="text" value="{{date('m-d-Y', strtotime($response->bday))}}" id="bday" style="width:15.9%;text-align:center">
                      Civil Status:
                      <input  class=" cert civil_status" type="text" value="{{$response->civil_stat}}" id="civil_status" style="width:15.7%;text-align:center">
                      Religion:
                      <input  class="cert religion" type="text" value="{{$response->religion}}" id="religion" style="width:19.3%;text-align:center">
                      Height:
                      <input  class="cert religion" type="text" value="{{$response->weight}}" id="religion" style="width:8%;text-align:center">
                      Weight:
                      <input  class="cert religion" type="text" value="{{$response->height}}" id="religion" style="width:8%;text-align:center">
                    </div>
                    <div class="row">
                        Boarding House Address:
                        <input  class=" cert bhAddress" type="text" value="{{ strtolower(utf8_decode($response->b_brgy))}}, {{ strtolower(utf8_decode($response->b_city))}}, {{ strtolower(utf8_decode($response->b_province))}}" id="bhAddress" style="width:82.7%;text-transform:capitalize" readonly>
                    </div>
                    <div class="row">
                        Home Address:
                        <input  class=" cert address" type="text" value="{{ strtolower(utf8_decode($response->brgy))}}, {{ strtolower(utf8_decode($response->city))}}, {{ strtolower(utf8_decode($response->province))}} " id="address" style="width:89.4%" readonly>
                    </div>
                    <div class="row">
                        Parent/Guardian:
                        <input  class=" cert guardian" type="text" value="{{$response->guardian}}" id="guardian" style="width:33.2%" readonly>
                        Parent/Guardian Contact No.:
                        <input  class="cert p_contactNo" type="text" value="{{$response->g_ContactNo}}" id="p_contactNo" style="width:35%" readonly>
                    </div>
                    <div class="row">
                        Guardian Address:
                        <input  class=" cert g_Address" type="text" value="{{$response->g_Address}}" id="g_Address" style="width:87.3%;" readonly>
                    </div>
                  </div>
                  <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                  <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div><br>
                  <div class="row" style="color:black;">
                      <div class="col-md-6">
                        <div class="form-group">
                         CHIEF COMPLAINT/S:
                          <textarea class="cert " rows="1" name="chief_complaint" style="width:68%">{{$response->complaint ?? ''}}</textarea>
                        </div><br>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          VITAL SIGNS:<br>
                          TEMP - <input type="text" class="cert d-inline-block " style="width:40%; display:inline-block;" value="{{$response->temp ?? ''}}" name="temp"> 
                          PR - <input type="text" class="cert d-inline-block " style="width:40.5%; display:inline-block;" value="{{$response->pr ?? ''}}" name="pr"><br>
                          RR - <input type="text" class="cert d-inline-block " style="width:44%; display:inline-block;" value="{{$response->rr ?? ''}}" name="rr"> 
                          BP - <input type="text" class="cert d-inline-block " style="width:40.5%; display:inline-block;" value="{{$response->pb ?? ''}}" name="bp">
                        </div>
                      </div>
                      <br>
                      <div class="col-md-6">
                        <div class="form-group">
                          ACTION TAKEN:
                          <textarea class="cert " rows="1" name="action_taken" style="width:75%">{{$response->action_taken ?? ''}}</textarea>
                        </div>
                      </div>
                      <div class="col-md-6"> 
                        <div class="form-group">
                          REASON/S FOR REFERRAL:
                          <textarea class="cert " rows="1" name="referral_reason" style="width:60%">{{$response->reason ?? ''}}</textarea>
                        </div>
                      </div>
                    </div><br>
                  <div class="col-sm-12 row" style="color:black;">
                        Referred by:<br>
                        <input  class="cert " name="" type="text" value="   EDMUNDO R. VILLA, MD., MM" id="" style="width:23%;" readonly>
                  </div>
                  <div class="for"  style="color:black;margin-left:95px">
                    Signature over Printed Name
                  </div><br><br>
                  <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                  <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                  <div class="row">
                          <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center;color:black;">(Cut and return to campus clinic)</div>
                  </div>
                  <div class="col-12  d-flex justify-content-center" >
                    @php
                    $campus_code = session('campus');
                    @endphp
                    @if($campus_code == 1)<img class="logo" src="images/logo/main-campus-logo.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 2)<img class="logo" src="images/logo/maasin-logo.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 3)<img class="logo" src="images/logo/tomas-oppus.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 4)<img class="logo" src="images/logo/bontoc.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 5)<img class="logo" src="images/logo/san-juan.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    @if($campus_code == 6)<img class="logo" src="images/logo/hinunangan.png" alt="" style="width: 300px; height: 100px;margin-right:30px">@endif
                    <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 80px; height: 80px;">
                </div>
                  <div class="row">
                     <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center;color:black;">Return Slip</div>
                  </div>
                  <div class="col-sm-12" style="text-align: right;color:black;">
                      Course:
                      <input  class="course cert " name="" type="text" value="{{$response->course}}" id="" style="width:10%" readonly>
                  </div>
                  <div class="col-sm-12" style="text-align: right;color:black;">
                      School Year:
                      <input  class="cert" name="" type="text" value="{{$addYear}}" id="fullname" style="width:10%" readonly>
                  </div>
                  <div class="div" style="color:black;">
                    Date:
                    <input  class="cert" name="" type="text" value="" id="date" >
                  </div>
                    <br>
                  <div class="form-group col-sm-12" style="color:black;">
                    <div class="row"> 
                      Name:
                      <input  class=" cert lastname" type="text" value="{{ ucwords(strtolower(utf8_decode($response->lastname)))}}" id="lastname" style="width:21%; text-align:center" readonly>&nbsp;
                      <input  class=" cert firstname" type="text" value="{{ ucwords(strtolower(utf8_decode($response->firstname)))}}" id="firstname" style="width:20%; text-align:center" readonly>&nbsp;
                      <input  class=" cert middlename" type="text" value="{{ucwords(strtolower(utf8_decode($response->middlename)))}}" id="middlename" style="width:20%; text-align:center" readonly>
                      Age:
                      <input  class="cert age" type="text" value="{{$response->age}}" id="age" style="width:8.2%;text-align:center" readonly>
                      Gender:
                      <input  class=" cert gender" type="text" value="{{$response->gender}}" id="gender" style="width:15.4%;text-align:center" readonly>
                    <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(Middle)
                    </div>
                  </div>
                    <div class="row">
                       Boarding House Address:
                       <input  class=" cert bhAddress" type="text" value="{{$response->b_brgy}}, {{$response->b_city}}, {{$response->b_province}}" id="bhAddress" style="width:51.2%;text-transform:capitalize" readonly>
                       Student Contact No.:
                       <input  class=" cert contactNo" type="text" value="{{$response->ContactNo}}" id="contactNo" style="width:15.9%" readonly>
                    </div>
                  </div>
                  <div class="form-group row col-12" style="color:black;">
                    <div class=" d-flex justify-content-left" style="font-weight: 700; font-size: 15px; font-style: bold;">Action taken/Remarks:</div>
                      <table class=" table">
                        <tr >
                          <td class="col-sm-12" height="100px" style="text-align:right"><br><br><br><br>
                            <div style="text-align: right;">
                                <input  class=" cert " name="" type="text" value="" id="" style="width:25%;text-align:center">
                            </div>
                            Signature over Printed Name&emsp;
                          </td>
                        </tr>
                      </table>
                  </div>
                  <div class="row footer-end">
                    <br><br>
                  <div class="col-12  d-flex justify-content-end" >
                    <div class="column" style="margin-right: 360px"> 
                      <br>
                      <div class="d-flex justify-content-left" style="font-size: 12px;color:black;">Doc. Code SLSU-QF-MD04 </span></div>
                      <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Revision: 03</div>
                      <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Date: 15 September 2025</div>
                    </div>
                      <img src="{{asset('images/logo/qs_star.png')}}" style="width: 120px; height: 100px;margin-right:30px;margin-left:150px">
                      <img src="{{asset('images/logo/socotec.png')}}" style="width: 160px; height: 90px;margin-right:10px">
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
            <form action="/approve-slip" method="POST" id="pendingForm">
            @csrf
              <div style="padding-bottom: 10px">
                <button type="button" class="col-md-12 btn btn-success approve" name="status" value="approve">Approve</button>
              </div>
                <button type="button" class="col-md-12 btn btn-danger disapprove" name="status" value="disapprove">Disapprove</button><hr>
                <button type="button"  id="backBtn" class="col-md-12 btn btn-secondary  float-right">Back</button>
                <textarea id="remarks" name="stat_remarks" style="display:none;"></textarea>
                <input class="col-11 id" type="hidden" name="id" value="{{$response->id}}">
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
console.log("cet: " + "{{$response->referTo}}");

$(document).ready(function() {
   var referTo = "{{$response->referTo}}";

   $("input:checkbox").each(function() {
     if (referTo.includes($(this).val())) {
           $(this).prop("checked", true);
         }
      });
  });

$(document).ready(function(){
    $("#backBtn").click(function(){
      window.history.back();
  })
 });


 $(document).ready(function() {
  //approved
  $('.approve').click(function() {
      var id = $('.id').val();
      var status = $(this).val();

      $.ajax({
          url: "/approve-slip",
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
                window.location.href="/view-generated-slip";
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
//disapprove
  $('.disapprove').click(function() {
      var id = $('.id').val();
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
          $.ajax({
              url: "/approve-slip",
              type: "POST",
              data: {
                  id: id,
                  status: status,
                  stat_remarks:remarks.value,
              },
              success: function(response) {
                  if (response.success) {
                    swal.fire({
                        title: "Success",
                        text: response.success,
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                  qwindow.location.href="/view-generated-slip";
          });
                  } else if (response.error) {
                      alert(response.error);
                  }
              },
              error: function(xhr) {
                  alert("An error occurred: " + xhr.status + " " + xhr.statusText);
              }
          });
      }).catch(swal.noop);
  });
});
</script>
@endsection
