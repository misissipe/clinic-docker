@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Preview Certificate')

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
   margin: 25.4mm 25.4mm 25.4mm 25.4mm;  
   font-family: Cambria;
   size: Auto;
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
          <div class="card">
            <div class="card-body">
              <div class="table-responsive" >
                <div class="col-12  d-flex justify-content-center" >
                  <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 450px; height: 150px;margin-right:30px">
                  <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 120px; height: 120px;">
                </div>
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                </div><br><br><br>
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center"><input  class="text-uppercase  name " type="text" value=" {{$doctor->FirstName ?? ''}} {{$doctor->MiddleName ?? ''}} {{$doctor->LastName ?? ''}} " id="name"  style="font-weight: 700; font-size: 20px; font-style: bold;text-align:center;width:50%" readonly> </div>
                  <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: bold; text-align:center;color:black;">Dentist</div>
                </div><br>
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 18px; font-style: bold; text-align:center;color:black;">CERTIFICATION</div>
                </div><br>
                <div class="class print-body">
                  <div class="row col-12">
                    <div style="font-weight: 400; font-size: 18px; font-style: bold;color:black;">To whom this may concern:</div>
                  </div><br>
                  <div class="form-group row col-12 input" style="color:black;">&emsp;&emsp;&emsp;
                      <div style="font-weight: 500; font-size: 18px; font-style: bold;">THIS IS TO CERTIFY</div>&nbsp;<div style="font-weight: 400; font-size: 18px;">that Mr./Ms./Mrs.</div>
                      <input  class="text-uppercase  name " type="text" value="{{utf8_decode($response->firstname)}} {{utf8_decode($response->middlename)}} {{utf8_decode($response->lastname)}}" id="name"  style="font-weight: 500; font-size: 18px; font-style: bold;text-align:center;width:62%" readonly> 
                    <div style="font-weight: 400; font-size: 18px;" >of</div>
                      <input  class=" text-uppercase  cy" type="text" value="{{utf8_decode($response->brgy)}} {{utf8_decode($response->city)}} {{utf8_decode($response->province)}}" id="cy"  style="font-weight: 600; font-size: 18px; font-style: bold;text-align:center;width:77.5%"readonly ><br>
                    <div style="font-weight: 400; font-size: 18px;color:black;"> has been treated by the </div>
                    <div style="font-weight: 400; font-size: 18px;color:black;"> undersigned for</div> 
                      <input  class=" text-uppercase  cy" type="text" value="{{$response->treated_by}}" id="cy"  style="font-weight: 600; font-size: 18px; font-style: bold;text-align:center;width:86%"readonly ><br>
                    <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 18px; font-style: italic;;margin-left:80px;color:black;">
                    </div>
                  </div><br><br><br>
                  <div class="form-group row col-12 input" style="color:black;">
                    &emsp;&emsp;&emsp; <div style="font-weight: 400; font-size: 18px;">It is recommended that he/she must</div>  <input  class=" text-uppercase  cy" type="text" value="{{$response->no_days}}" id="cy"  style="font-weight: 600; font-size: 18px; font-style: bold;text-align:center;width:30%"readonly ><br><div style="font-weight: 400; font-size: 18px;">day(s) of rest.</div>
                  </div>
                  <div class="form-group row col-12 input" style="color:black;">
                    &emsp;&emsp;&emsp; <div style="font-weight: 400; font-size: 18px;">This is issued upon his/her request for whatever legal purpose it may serve.</div>
                  </div>
                  <div class="form-group row col-12 input" style="color:black;">
                    &emsp;&emsp;&emsp; <div style="font-weight: 400; font-size: 18px;">Given this</div><input  class=" text-uppercase  cy" type="text" value="{{$formattedDay}}" id="cy"  style="font-weight: 600; font-size: 18px; font-style: bold;text-align:center;width:10%"readonly ><div style="font-weight: 400; font-size: 18px;">day of</div>
                    <input  class=" text-uppercase  cy" type="text" value="{{$month}}. {{$year}}" id="cy"  style="font-weight: 600; font-size: 18px; font-style: bold;text-align:center;width:20%"readonly ><div style="font-weight: 400; font-size: 18px;">at Southern Leyte State University</div>
                    <div style="font-weight: 400; font-size: 18px;">
                      @php
                       $campus_add = [
                          1 => 'Main Campus, San Roque, Sogod',
                          2 => 'Maasin City Campus, Maasin City',
                          3 => 'Tomas Oppus Campus, San Isidro, Tomas Oppus',
                          4 => 'Bontoc Campus, Bontoc',
                          5 => 'San Juan Campus, San Juan',
                          6 => 'Hinunangan Campus, Hinunangan',
                      ];

                      $campus = session('campus');
                  @endphp
                  
                  @if($campus)
                      <div style="font-weight: 400; font-size: 18px;">
                          {{ $campus_add[$campus] }}, Southern Leyte, philippines.
                      </div>
                  @endif
                   </div>
                  </div>
                </div><br><br><br>
                <div class="row" style="color: black;">
                  <div class="form-group col-12 text-right"> 
                    <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 30%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-left:60%;">
                      {{$doctor->FirstName ?? ''}} {{$doctor->MiddleName ?? ''}} {{$doctor->LastName ?? ''}} 
                  </span>
                  </div>
                  <div class="form-group col-12 text-right"> 
                    <div style="font-weight: 400; font-size: 18px;">License No.
                      <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 30%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
                        {{$doctor->license ?? ''}}
                      </span>
                    </div>
                  </div>
                </div>
                <br><br><br><br><br>
                <hr style="border:1px solid rgb(0, 0, 0);">
                <div class="row footer-end"> <br><br>
                  {{-- <div class="col-1"></div> --}}
                  <br><br><br>
                  <div class="col-12  d-flex justify-content-end" >
                    <div class="column" style="margin-right:100px"> <br>
                      <div class="d-flex justify-content-left" style="font-size: 12px;color:black;">Doc. Code SLSU-QF-MD16</span></div>
                      <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Revision: 00</div>
                      <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Date: 22 February 2023</div>
                    </div>
                    <img src="{{asset('images/logo/sq_star.png')}}" style="width: 250px; height: 90px;margin-right:80px">
                    <img src="{{asset('images/logo/socotec.png')}}" style="width: 160px; height: 90px;margin-right:150px">
                  </div>
                </div>
              </div>
            </div>
          </div>
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
        <form action="/dental-certificate-pdf" method="get" target="_blank" class="float-right">
          <input type="hidden" name="id" value="{{ $id }}">
          <button type="submit" class="btn btn-primary" style="font-size: 15px; color: rgb(255, 255, 255);"> Print</button>
        </form>
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

//Search-InputF
 $(document).ready(function() {
  $("#submitBtn").submit(function() {
    event.preventDefault();
    var search = $('#searchInput').val();
      $.ajax({
        type:'post',
        url:'/dental-certificate',
        data:{search:search},

        success:function(data){
          $('#myTable').html(data);   
        } 
      })
    })
 });


$(document).ready(function(){
    $("#backbutton").click(function(){
      window.history.back();
  })
 });


//Back button in View
$(document).ready(function(){
    $("#cancelBtnprint").click(function(){
      window.location.href="/dental-certificate";
  })
 });


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