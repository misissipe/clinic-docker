@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
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
      border-width: 0;
      border-color: rgb(58, 57, 57);
    }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
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
  .btn-sm {
    width: 70px; /* adjust the width as needed */
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
 left: 150px;
   }
   /* .print-body{
     position: absolute;
     top: 20px;
     left: 0px;
     right: 0px;
     max-width: 12in;
     max-height: 13in;
   }*/
   /* .footer-end{
   position:  relative;
   bottom: 1px;
   left: 100px;
   }  */
   
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
   size: A4;
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
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs border-0" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="generate-tab" data-toggle="tab" href="#generate" aria-controls="generate" role="tab" aria-selected="false" style="display : none">
                    <i class="bx bxs-bookmark-star align-middle"></i>
                    <span class="align-middle">Generate Referral Slip</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="print-tab" data-toggle="tab" href="#print" aria-controls="print" role="tab" aria-selected="false" style="display : none">
                    <i class="bx bx-list-ul align-middle"></i>
                    <span class="align-middle">print</span>
                  </a>
                </li>
              </ul>

              <div class="tab-content">
{{--print-tab--}}
                <div class="tab-pane " id="generate" aria-labelledby="generate-tab" role="tabpanel">
                     <h5 style="font-weight: bold; font-style: italic;color:royalblue)">GENERATE REFERRAL SLIP</h5>
                  <div id="printThis">
                    <div class="col-12  d-flex justify-content-center" >
                      <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;">
                      <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center;color:black;">Referral Slip</div>
                    </div>
                    <div style="font-weight: 400; font-size: 18px; text-align: right;color:black;">
                      Course:
                      <input  class="col-sm-2 course cert " name="" type="text" value="{{$generate->accro}}" id="fullname">
                    </div>
                    <div  style="font-weight: 400; font-size: 18px;text-align: right;color:black;">
                      School Year:
                      <input  class="col-2 cert" name="" type="text" value="" id="fullname" >
                    </div>
                    <div  style="font-weight: 400; font-size: 18px;text-align: right;color:black;">
                      Date:
                      <input  class="col-sm-2 date cert " name="" type="text" value="{{ date('m-d-Y', strtotime($generate->date))}}" id="date">
                    </div>
                    <div class="form-group col-12">
                      <div class="row" style="font-weight: 700; font-size:  20px;font-style: bold;color:black;">
                        REFERRED TO:
                      </div> 
                    <div style="font-weight: 400; font-size: 18px;margin-left:100px;color:black;">
                     <input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                      HOSPITAL 
                    </div>
                    <div style="font-weight: 400; font-size: 18px;color:black;margin-left:100px;">
                      <input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                      RHU
                    </div> 
                    <div style="font-weight: 400; font-size: 18px;color:black;margin-left:100px;">
                      <input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                      VISITING PHYSICIAN
                    </div>
                    <div style="font-weight: 400; font-size: 18px;color:black;margin-left:100px;">
                       <input class="textbox" type="checkbox" id="others" name="referTo[]" value="others">
                        Others,please specify
                        <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                    </div> 
                  </div>
                  <div class="form-group col-sm-12" style="font-weight: 300; font-size: 18px; align-text:middle;color:black;">
                    <div class="row">
                      Name:
                      <input  class=" cert lastname" type="text" value="{{$generate->lastname}}" id="lastname" style="width:22%;text-align:center">&nbsp;
                      <input  class=" cert firstname" type="text" value="{{$generate->firstname}}" id="firstname" style="width:20%;text-align:center">&nbsp;
                      <input  class=" cert middlename" type="text" value="{{$generate->middlename}}" id="middlename" style="width:20%;text-align:center">
                      Age:
                      <input  class="cert age" type="text" value="{{$generate->age}}" id="age" style="width:8%;text-align:center">
                      Gender:
                      <input  class=" cert gender" type="text" value="{{$generate->gender}}" id="gender" style="width:15%;text-align:center">
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                      </div>
                    </div>
                    <div class="row" style="color:black;">
                      Date of Birth:
                      <input  class=" cert BirthDate" type="date" value="{{$newbday}}" id="BirthDate" style="width:16%;text-align:center">
                      Civil Status:
                      <input  class=" cert civil_status" type="text" value="{{$generate->civil_status}}" id="civil_status" style="width:16%;text-align:center">
                      Nationality:
                      <input  class=" cert nationality" type="text" value="{{$generate->nationality}}" id="nationality" style="width:16%;text-align:center">
                      Religion:
                      <input  class="cert religion" type="text" value="{{$generate->religion}}" id="religion" style="width:17.3%;text-align:center">
                    </div>
                    <div class="row">
                      Boarding House Address:
                      <input  class=" cert bhAddress" type="text" value="{{$generate->b_brgy}}, {{$generate->b_city}}, {{$generate->b_province}}" id="bhaddress" style="width:81%">
                    </div>
                    <div class="row">
                      Home Address:
                      <input  class=" cert address" type="text" value="{{$generate->brgy}}, {{$generate->city}}, {{$generate->province}}" id="address" style="width:88.5%">
                    </div>
                    <div class="row" style="color:black;">
                      Parent/Guardian:
                      <input  class=" cert guardian" type="text" value="{{$generate->EC_name}}" id="guardian" style="width:41.5%">
                      Parent/Guardian Contact No.:
                      <input  class="cert p_contactNo" type="text" value="{{$generate->EC_contactNo}}" id="p_contactNo" style="width:23%">
                    </div>
                    <div class="row">
                      Guardian Address:
                      <input  class=" cert g_Address" type="text" value="{{$generate->EC_brgy}}, {{$generate->EC_city}} {{$generate->EC_province}}" id="g_Address" style="width:86%;">
                    </div>
                  </div><div class="break"></div>
                  <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                  <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                  <div class="" style="font-weight: 700; font-size: 18px;font-style: bold;color:black;">REASON/s FOR REFERRAL:
                    <textarea class=" remarks"  name="reason" value="" id="reason" rows="1" style="width:100%;">{{$generate->reason}}</textarea>
                  </div><br><br>
                  <div style="font-weight: 400; font-size: 18px; text-align: left;color:black;">
                    Referred by:
                    <input  class="col-3 cert" name="" type="text" value="EDMUNDO R. VILLA, MD., MM"  style="text-align:center">
                  </div><div class="for"  style="color:black;margin-left:140px">
                    Signature over Printed Name
                  </div>
                    <br>
                  <div class="line" style="border-bottom: 3px dashed rgb(110, 109, 109);margin:3px"></div>
                  <div class="line" style="border-bottom: 3px dashed rgb(110, 109, 109);margin:3px"></div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                  </div>
                  <div class="col-12  d-flex justify-content-center" >
                    <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;">
                    <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center;color:black;">Return Slip</div>
                  </div>
                  <div style="font-weight: 400; font-size: 18px;text-align: right;color:black;">
                    Course:
                    <input  class="col-2 course cert " name="{{$generate->accro}}" type="text" value="" id="course">
                  </div>
                  <div style="font-weight: 400; font-size: 18px;text-align: right;color:black;">
                    School Year:
                    <input  class="col-2 cert" name="" type="text" value="" id="sy" >
                  </div>
                  <div class="form-group row col-12"  style="font-weight: 400; font-size: 18px;color:black;">
                    Date:
                    <input  class=" cert " type="text" value="" id="date">&nbsp;
                  </div>  
                  <div class="form-group col-sm-12" style="font-weight: 300; font-size: 18px;color:black;">
                    <div class="row">
                      Name:
                      <input  class=" cert lastname" type="text" value="{{$generate->lastname}}" id="lastname" style="width:22%;text-align:center">&nbsp;
                      <input  class=" cert firstname" type="text" value="{{$generate->firstname}}" id="firstname" style="width:20%;text-align:center">&nbsp;
                      <input  class=" cert middlename" type="text" value="{{$generate->middlename}}" id="middlename" style="width:20%;text-align:center">
                      Age:
                      <input  class="cert age" type="text" value="{{$generate->age}}" id="age" style="width:8%;text-align:center">
                      Gender:
                      <input  class=" cert gender" type="text" value="{{$generate->gender}}" id="gender" style="width:15%;text-align:center">
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                      </div>
                    </div>
                    <div class="row" style="color:black;">
                      Boarding House Address:
                      <input  class=" cert bhaddress" type="text" value="{{$generate->b_brgy}}, {{$generate->b_city}}, {{$generate->b_province}}" id="bhaddress" style="width:49.8%">
                      Student Contact No.:
                      <input  class=" cert contactNo" type="text" value="{{$generate->ContactNo}}" id="ContactNo" style="width:15.5%">
                    </div>
                  </div>
                  <div class="d-flex justify-content-left" style="font-weight: 700; font-size: 20px; font-style: bold; text-align:center">Action taken/Remarks:</div>
                    <table class="table" style="color:black;">
                      <tr>
                        <td class="a" height="100px"><br><br><br><br>
                          <div style="text-align: right;">
                            <input  class="col-3 cert " name="" type="text" value="" id="" style="text-align:center">
                          </div>
                           Signature over Printed Name&emsp;
                        </td>
                      </tr>
                    </table>
                    <div class="row footer-end">
                      <br><br><br>
                      <div class="col-12  d-flex justify-content-end" >
                        <div class="column" style="margin-right:50px"> 
                          <br>
                           <div class="d-flex justify-content-left" style="font-size: 20px;color:black;">Doc. Code SLSU-QF-MD04</span></div>
                          <div class=" d-flex justify-content-left" style="font-size: 20px;color:black;">Revision: 02</div>
                          <div class=" d-flex justify-content-left" style="font-size: 20px;color:black;">Date: 08 April 2022</div>
                        </div>
                        <img src="{{asset('images/logo/sq_star.png')}}" style="width: 350px; height: 128px;margin-right:60px">
                        <img src="{{asset('images/logo/socotec.png')}}" style="width: 260px; height: 120px;margin-right:50px">
                      </div>
                    </div>
                  </div>
                </div>
{{--show-tab--}}
                <div class="tab-pane active" id="print" aria-labelledby="print-tab" role="tabpanel">
                  <div id="">
                    <div class="col-12  d-flex justify-content-center" >
                      <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;">
                      <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                  </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center;color:black;">Referral Slip</div>
                    </div>
                    <div class="col-sm-12" style="text-align: right;color:black;">
                      Course:
                      <input  class="course cert " name="" type="text" value="{{$generate->accro}}" id="course" style="width:10%">
                    </div>
                    <div class="col-sm-12" style="text-align: right;color:black;">
                      School Year:
                      <input  class="cert" name="" type="text" value="" id="fullname" style="width:10%">
                    </div><br>
                    <div class="col-sm-12" style="text-align: right;color:black;">
                      Date:
                      <input  class=" date cert " name="" type="text" value="{{ date('m-d-Y', strtotime($generate->date))}}" id="date" style="width:10%">
                    </div>
                    <div class="form-group col-12">
                      <div class="row" style="font-weight: 600; font-size: 15px;font-style: bold;color:black;">
                        REFERRED TO:
                      </div> 
                      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:70px">
                        <input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                        HOSPITAL 
                      </div>
                      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:70px">
                        <input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                        RHU
                      </div> 
                      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:70px">
                       <input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                        VISITING PHYSICIAN
                      </div>
                      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:70px">
                        <input class="textbox" type="checkbox" id="others" name="referTo[]" value="others">
                        OTHERS,(please specify)
                        <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                      </div> 
                    </div>
                    <div class="form-group col-sm-12" style="color:black;" >
                      <div class="row"> 
                        Name:
                        <input  class=" cert lastname" type="text" value="{{$generate->lastname}}" id="lastname" style="width:21%; text-align:center">&nbsp;
                        <input  class=" cert firstname" type="text" value="{{$generate->firstname}}" id="firstname" style="width:20%; text-align:center">&nbsp;
                        <input  class=" cert middlename" type="text" value="{{$generate->middlename}}" id="middlename" style="width:20%; text-align:center">
                        Age:
                        <input  class="cert age" type="text" value="{{$generate->age}}" id="age" style="width:8%;text-align:center">
                        Gender:
                        <input  class=" cert gender" type="text" value="{{$generate->gender}}" id="gender" style="width:15.4%;text-align:center">
                        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(Last)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                        </div>
                      </div>
                      <div class="row" style="color:black;">
                        Date of Birth:
                        <input  class=" cert BirthDate" type="date" value="{{$newbday}}" id="BirthDate" style="width:16%;text-align:center">
                        Civil Status:
                        <input  class=" cert civil_status" type="text" value="{{$generate->civil_status}}" id="civil_status" style="width:16%;text-align:center">
                        Nationality:
                        <input  class=" cert nationality" type="text" value="{{$generate->nationality}}" id="nationality" style="width:17%;text-align:center">
                        Religion:
                        <input  class="cert religion" type="text" value="{{$generate->religion}}" id="religion" style="width:18%;text-align:center">
                      </div>
                      <div class="row" style="color:black;"> 
                        Boarding House Address:
                        <input  class=" cert bhAddress" type="text" value="{{$generate->b_brgy}}, {{$generate->b_city}}, {{$generate->b_province}}" id="bhAddress" style="width:81%">
                      </div>
                      <div class="row" style="color:black;">
                        Home Address: &nbsp;
                        <input  class=" cert address" type="text" value="{{$generate->brgy}}, {{$generate->city}}, {{$generate->province}}" id="address" style="width:87.2%">
                      </div>
                      <div class="row" style="color:black;">
                        Parent/Guardian:
                        <input  class=" cert guardian" type="text" value="{{$generate->EC_name}}" id="guardian" style="width:37%">
                        Parent/Guardian Contact No.:
                        <input  class="cert p_contactNo" type="text" value="{{$generate->EC_contactNo}}" id="p_contactNo" style="width:29.2%">
                      </div>
                      <div class="row" style="color:black;">
                        Guardian Address:
                        <input  class=" cert g_Address" type="text" value="{{$generate->EC_brgy}}, {{$generate->EC_city}} {{$generate->EC_province}}" id="g_Address" style="width:85.8%;">
                      </div>
                    </div><br>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div><br>
                    <div class="" style="font-weight: 700; font-size: 15px;font-style: bold;color:black;">REASON/s FOR REFERRAL:
                      <textarea class=" recommendation"  name="recommendation" value="" id="recommendation" rows="1" style="width:100%;">{{$generate->reason}}</textarea>
                    </div><br><br>
                    <div class="col-sm-12 row" style="color:black;">
                      Referred by:<br>
                      <input  class="cert " name="" type="text" value="{{$doctor->FirstName}} {{$doctor->MiddleName}}. {{$doctor->LastName}} " id="" style="width:23%;" readonly>
                    </div>
                    <div class="for"  style="color:black;margin-left:95px">
                      Signature over Printed Name
                    </div><br><br>
                    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                    </div>
                    <div class="col-12  d-flex justify-content-center" >
                      <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;">
                      <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center;color:black;">Return Slip</div>
                    </div>
                    <div class="col-sm-12" style="text-align: right;color:black;">
                      Course:
                        <input  class="course cert " name="" type="text" value="{{$generate->accro}}" id="" style="width:10%">
                    </div>
                    <div class="col-sm-12" style="text-align: right;color:black;">
                      School Year:
                      <input  class="cert" name="" type="text" value="" id="fullname" style="width:10%;color:black;">
                    </div>
                      Date:
                      <input  class="cert" name="" type="text" value="" id="date" >
                      <br><br><br>
                    <div class="form-group col-sm-12" style="color:black;">
                      <div class="row"> 
                        Name:
                        <input  class=" cert lastname" type="text" value="{{$generate->lastname}}" id="lastname" style="width:21%; text-align:center">&nbsp;
                        <input  class=" cert firstname" type="text" value="{{$generate->firstname}}" id="firstname" style="width:20%; text-align:center">&nbsp;
                        <input  class=" cert middlename" type="text" value="{{$generate->middlename}}" id="middlename" style="width:20%; text-align:center">
                        Age:
                        <input  class="cert age" type="text" value="{{$generate->age}}" id="age" style="width:8%;text-align:center">
                        Gender:
                        <input  class=" cert gender" type="text" value="{{$generate->gender}}" id="gender" style="width:15.4%;text-align:center">
                        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                        </div>
                      </div>
                      <div class="row" style="color:black;">
                        Boarding House Address:
                        <input  class=" cert bhAddress" type="text" value="{{$generate->b_brgy}}, {{$generate->b_city}}, {{$generate->b_province}}" id="bhAddress" style="width:55%">
                        Student Contact No.:
                        <input  class=" cert " type="text" value="{{$generate->ContactNo}}" id="contactNo" style="width:11%">
                      </div>
                    </div>
                    <div class="form-group row col-12">
                      <div class=" d-flex justify-content-left" style="font-weight: 700; font-size: 15px; font-style: bold;color:black;">Action taken/Remarks:</div>
                        <table class=" table" style="color:black;">
                          <tr >
                            <td class="col-sm-12 a " height="100px"><br><br><br><br>
                              <div style="text-align: right;">
                                <input  class="cert " name="" type="text" value="" id="" style="width:23%;text-align:center">
                              </div>
                              Signature over Printed Name
                            </td>
                          </tr>
                        </table>
                    </div>
                    <div class="row footer-end">
                      <br><br>
                      <div class="col-12  d-flex justify-content-center" >
                        <div class="column" style="margin-right:50px"> 
                          <br>
                           <div class="d-flex justify-content-left" style="font-size: 12px;color:black;">Doc. Code SLSU-QF-MD04</span></div>
                          <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Revision: 02</div>
                          <div class=" d-flex justify-content-left" style="font-size: 12px;color:black;">Date: 08 April 2022</div>
                        </div>
                        <img src="{{asset('images/logo/sq_star.png')}}" style="width: 250px; height: 90px;margin-right:60px">
                        <img src="{{asset('images/logo/socotec.png')}}" style="width: 160px; height: 90px;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>{{--end-tab-content--}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-1">
      {{-- <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(119, 241, 119); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <form action="/generatedSlip"  method="post" id="generatedSlip">
            @csrf
            <input  class="col-11 id" type="text" name="id" value="{{$generate->id}}" id="id" hidden> 
            <input  class="col-11 " type="text" name="purpose" value="Issuance of Slip" id="" hidden> 
            <button type="submit" class="btn btn-default button" id="generate"><a style="color: rgb(255, 255, 255); font-size: 15px;">Generated</a></button>
          </form>
        </div>
      </div> --}}
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(84, 145, 236); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <button type="button" class="btn btn-default button" id="btnPrint"><a style="color: rgb(255, 255, 255); font-size: 15px;">Print</a></button>
        </div>
      </div>
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(75, 95, 130); height: 40px; margin-top: 0;">
        <div class="card-body">
          <button type="button" id="cancelBtnprint" class="btn btn-default button"><a style="color: rgb(255, 255, 255); font-size: 15px;">Cancel</a></button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});


//To Print from record
 $(document).on('click', '.printBtn', function(){
  // const id = $(this).data('id');
 
    $.ajax({
    type: 'post',
    url: '/print-record',
    data: { id: $(this).data('id') },
    dataType: 'json',
   
    success: function(response) {
      console.log(response);
      id = response.id;
      console.log(response.id);
      console.log(response.cert_issued)
                var  referTo = response.referTo

                $("input:checkbox").each(function() {
                        if (referTo.includes($(this).prop("value"))) {
                            $(this).prop("checked", true);
                        }
                    });

                $('.id').val(response.id);
                $('#id').val(response.patientId);
                $('.lastname').val(response.lastname);
                $('.firstname').val(response.firstname);
                $('.middlename').val(response.middlename);
                $('#course').val(response.Course);
                $('.age').val(response.age);
                $('.gender').val(response.gender);
                $('.bday').val(response.BirthDate); 
                $('.civil_status').val(response.civil_status);
                $('.nationality').val(response.nationality);
                $('.religion').val(response.religion);
                $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province])
                $('.bhAddress').val([response.b_brgy]+', '+[response.b_city]+', '+[response.b_province]);;
                $('#contactNo').val(response.ContactNo);
                $('.guardian').val(response.guardian);
                $('.p_contactNo').val(response.p_contactNo);
                $('.g_Address').val(response.g_Address);
                $('.reason').val(response.reason);
                $('.others').val(response.others);

                $('.tab-pane').removeClass('active')
                $('#print').addClass('active')
                $('.nav-link').removeClass('active')
                $('#print-tab').addClass('active')
                $("#print").removeAttr("style").hide()
                $("#print").show()
      }
    })
  });

//Print Document
document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();


}
//Back button
 $(document).ready(function(){
        $("#returnHome").click(function(){
          window.history.back();
      })
    })
 
console.log("cet: " + "{{$generate->referTo}}");

$(document).ready(function() {
 var referTo = "{{$generate->referTo}}";

 $("input:checkbox").each(function() {
   if (referTo.includes($(this).val())) {
     $(this).prop("checked", true);
   }
 });
});

$("#generatedSlip").submit(function(e) {
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