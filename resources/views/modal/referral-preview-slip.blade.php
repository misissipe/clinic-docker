@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Preview Slip')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
    @if (isset($response))
    @if ($request->has('id'))
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-body mt-0 p-1">
              <div class="table-responsive">
                <div id="printThis">
                  <div class="col-12  d-flex justify-content-center" >
                    <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;margin-right:30px">
                    <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Referral Slip</div>
                  </div>
                  <div class="col-sm-12" style="text-align: right">
                    Course:
                    <input  class="course cert " name="" type="text" value="{{$course->accro}}" id="course" style="width:10%">
                  </div>
                  <div class="col-sm-12" style="text-align: right">
                    School Year:
                    <input  class="cert" name="" type="text" value="{{$addYear}}" id="fullname" style="width:10%">
                  </div><br>
                  <div class="col-sm-12" style="text-align: right">
                    Date:
                    <input  class=" date cert " name="date" type="text" value="{{date('m-d-Y', strtotime($response->date))}}" id="date" style="width:10%">
                  </div>
                  <div class="form-group col-12">
                    <div class="row" style="font-weight: 600; font-size: 15px;font-style: bold;">
                    REFERRED TO:
                    </div> 
                    <div style="font-weight: 400; font-size: 12px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                      HOSPITAL 
                    </div>
                    <div style="font-weight: 400; font-size: 12px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                      RHU
                    </div> 
                    <div style="font-weight: 400; font-size: 12px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                      VISITING PHYSICIAN
                    </div>
                    <div style="font-weight: 400; font-size: 12px;">
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others">
                      OTHERS,(please specify)
                      <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                    </div> 
                  </div>
                  <div class="form-group col-sm-12" >
                    <div class="row"> 
                      Name:
                      <input  class=" cert lastname" type="text" value="{{$response->lastname}}" id="lastname" style="width:21%; text-align:center">&nbsp;
                      <input  class=" cert firstname" type="text" value="{{$response->firstname}}" id="firstname" style="width:20%; text-align:center">&nbsp;
                      <input  class=" cert middlename" type="text" value="{{$response->middlename}}" id="middlename" style="width:20%; text-align:center">
                      Age:
                      <input  class="cert age" type="text" value="{{$age}}" id="age" style="width:9.5%;text-align:center">
                      Gender:
                      <input  class=" cert gender" type="text" value="{{$response->gender}}" id="gender" style="width:15.5%;text-align:center">
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                      </div>
                    </div>
                    <div class="row">
                      Date of Birth:
                      <input  class=" cert bday" type="text" value="{{date('m-d-Y', strtotime($newbday))}}" id="bday" style="width:15.9%;text-align:center">
                      Civil Status:
                      <input  class=" cert civil_status" type="text" value="{{$response->civil_stat}}" id="civil_status" style="width:15.7%;text-align:center">
                      Nationality:
                      <input  class=" cert nationality" type="text" value="{{$response->nationality}}" id="nationality" style="width:18%;text-align:center">
                      Religion:
                      <input  class="cert religion" type="text" value="{{$response->religion}}" id="religion" style="width:19.3%;text-align:center">
                    </div>
                    <div class="row">
                      Boarding House Address:
                      <input  class=" cert bhAddress" type="text" value="{{$response->b_brgy}}, {{$response->b_city}}, {{$response->b_province}}" id="bhAddress" style="width:82.7%">
                    </div>
                    <div class="row">
                      Home Address: &nbsp;
                      <input  class=" cert address" type="text" value="{{$response->brgy}}, {{$response->city}}, {{$response->province}} " id="address" style="width:88.8%">
                    </div>
                    <div class="row">
                      Parent/Guardian:
                      <input  class=" cert guardian" type="text" value="{{$response->guardian}}" id="guardian" style="width:33.2%">
                      Parent/Guardian Contact No.:
                      <input  class="cert p_contactNo" type="text" value="{{$response->g_ContactNo}}" id="p_contactNo" style="width:35%">
                    </div>
                    <div class="row">
                      Guardian Address:
                      <input  class=" cert g_Address" type="text" value="{{$response->g_Address}}" id="g_Address" style="width:87.3%;">
                    </div>
                  </div><br>
                  <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                  <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div><br>
                  <div class="" style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:
                      <textarea class=" reason"  name="reason" value="" id="reason" rows="1" style="width:100%;">{{$response->reason}}</textarea>
                  </div><br><br>
                  <div class="col-sm-12 row" >
                      Referred by:<br>
                      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 40%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-right:20%">
                        {{$doctor->FirstName}} {{$doctor->MiddleName}} {{$doctor->LastName}} 
                    </span>
                  </div>
                      &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;Signature over Printed Name<br><br>
                  <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                  <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                  <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                  </div>
                  <div class="col-12  d-flex justify-content-center" >
                    <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;margin-right:30px">
                    <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Return Slip</div>
                  </div>
                  <div class="col-sm-12" style="text-align: right">
                    Course:
                    <input  class="course cert " name="" type="text" value="{{$course->accro}}" id="" style="width:10%">
                  </div>
                  <div class="col-sm-12" style="text-align: right">
                    School Year:
                    <input  class="cert" name="" type="text" value="{{$addYear}}" id="fullname" style="width:10%">
                  </div>
                    Date:
                    <input  class="col-1  cert" name="" type="text" value="" id="" ><br><br>
                  <div class="form-group col-sm-12" >
                    <div class="row"> 
                      Name:
                      <input  class=" cert lastname" type="text" value="{{$response->lastname}}" id="lastname" style="width:21%; text-align:center">&nbsp;
                      <input  class=" cert firstname" type="text" value="{{$response->firstname}}" id="firstname" style="width:20%; text-align:center">&nbsp;
                      <input  class=" cert middlename" type="text" value="{{$response->middlename}}" id="middlename" style="width:20%; text-align:center">
                      Age:
                      <input  class="cert age" type="text" value="{{$response->age}}" id="age" style="width:8.5%;text-align:center">
                      Gender:
                      <input  class=" cert gender" type="text" value="{{$response->gender}}" id="gender" style="width:15.5%;text-align:center">
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                      </div>
                    </div>
                      <div class="row">
                        Boarding House Address:
                        <input  class=" cert bhAddress" type="text" value="{{$response->b_brgy}}, {{$response->b_city}}, {{$response->b_province}}" id="bhAddress" style="width:51.5%">
                        Student Contact No.:
                        <input  class=" cert contactNo" type="text" value="{{$response->ContactNo}}" id="contactNo" style="width:15.9%">
                      </div>
                  </div>
                  <div class="form-group row col-12">
                      <div class=" d-flex justify-content-left" style="font-weight: 700; font-size: 15px; font-style: bold;">Action taken/Remarks:</div>
                        <table class=" table">
                          <tr >
                            <td class="col-sm-12 a " height="100px"><br><br><br><br>
                              <div style="text-align: right;">
                                <input  class=" cert " name="" type="text" value="" id="" style="width:22%;text-align:center">
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
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card">
        <div class="card-body">
          <div style="display: flex; flex-direction: column;">
            <form action="/approval" method="POST" id="pendingSlip">
            @csrf
              <button type="submit" style="background-color: white; height:40px;" class="col-md-12 btn btn-primary button">Submit</button>
              <input class="col-11 id" type="hidden" name="id" value="{{$encryptedId}}" id="id">
              <input class="col-11 id" type="hidden" value="{{$response->patientId}}" id="patientId">
              <input class="form-control" name="role" type="hidden" value="{{$role}}" id="" >
              <input class="col-11" type="hidden" name="status" value="Pending">
            </form>
          </div><hr>
          <div style="display: flex; flex-direction: column;">
            <button type="button" id="backbutton" style="background-color: white;" class=" btn btn-secondary button">Back</button>
          </div>
        </div>
      </div>
    </div>
{{-- if ends here --}}
    @elseif ($request->has('to_id'))
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="card border">
              <div class="card-body mt-0 p-1">
                <div class="table-responsive">
                  <div id="printThis">
                    <div class="col-12  d-flex justify-content-center" >
                      <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;margin-right:30px">
                      <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                  </div>
                    <div class="row">
                            <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                    </div>
                    <div class="row">
                            <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Referral Slip</div>
                    </div>
                    <div class="col-sm-12" style="text-align: right">
                            Course:
                            <input  class="course cert " name="" type="text" value="{{$course->accro}}" id="course" style="width:10%">
                    </div>
                    <div class="col-sm-12" style="text-align: right">
                            School Year:
                            <input  class="cert" name="" type="text" value="{{$addYear}}" id="fullname" style="width:10%">
                    </div><br>
                    <div class="col-sm-12" style="text-align: right">
                            Date:
                            <input  class=" date cert " name="date" type="text" value="{{date('m-d-Y', strtotime($response->date))}}" id="date" style="width:10%">
                    </div>
                    <div class="form-group col-12">
                      <div class="row" style="font-weight: 600; font-size: 15px;font-style: bold;">
                        REFERRED TO:
                      </div> 
                      <div style="font-weight: 400; font-size: 12px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                        HOSPITAL 
                      </div>
                      <div style="font-weight: 400; font-size: 12px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                        RHU
                      </div> 
                      <div style="font-weight: 400; font-size: 12px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                        VISITING PHYSICIAN
                      </div>
                      <div style="font-weight: 400; font-size: 12px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others">
                        OTHERS,(please specify)
                        <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                      </div> 
                    </div>
                    <div class="form-group col-sm-12" >
                      <div class="row"> 
                        Name:
                        <input  class=" cert lastname" type="text" value="{{$response->lastname}}" id="lastname" style="width:21%; text-align:center">&nbsp;
                        <input  class=" cert firstname" type="text" value="{{$response->firstname}}" id="firstname" style="width:20%; text-align:center">&nbsp;
                        <input  class=" cert middlename" type="text" value="{{$response->middlename}}" id="middlename" style="width:20%; text-align:center">
                        Age:
                        <input  class="cert age" type="text" value="{{$age}}" id="age" style="width:9.5%;text-align:center">
                        Gender:
                        <input  class=" cert gender" type="text" value="{{$response->gender}}" id="gender" style="width:15.5%;text-align:center">
                        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                        </div>
                      </div>
                      <div class="row">
                        Date of Birth:
                        <input  class=" cert bday" type="text" value="{{date('m-d-Y', strtotime($newbday))}}" id="bday" style="width:18%;text-align:center">
                        Civil Status:
                        <input  class=" cert civil_status" type="text" value="{{$response->civil_stat}}" id="civil_status" style="width:16%;text-align:center">
                        Nationality:
                        <input  class=" cert nationality" type="text" value="{{$response->nationality}}" id="nationality" style="width:18%;text-align:center">
                        Religion:
                        <input  class="cert religion" type="text" value="{{$response->religion}}" id="religion" style="width:19.3%;text-align:center">
                      </div>
                      <div class="row">
                        Boarding House Address:
                        <input  class=" cert bhAddress" type="text" value="{{$response->b_brgy}}, {{$response->b_city}}, {{$response->b_province}}" id="bhAddress" style="width:83.4%">
                      </div>
                      <div class="row">
                        Home Address: &nbsp;
                        <input  class=" cert address" type="text" value="{{$response->brgy}}, {{$response->city}}, {{$response->province}} " id="address" style="width:88.7%">
                      </div>
                      <div class="row">
                         Parent/Guardian:
                        <input  class=" cert guardian" type="text" value="{{$response->guardian}}" id="guardian" style="width:35.5%">
                        Parent/Guardian Contact No.:
                        <input  class="cert p_contactNo" type="text" value="{{$response->g_ContactNo}}" id="p_contactNo" style="width:35%">
                      </div>
                      <div class="row">
                        Guardian Address:
                        <input  class=" cert g_Address" type="text" value="{{$response->g_Address}}" id="g_Address" style="width:87.5%;">
                      </div>
                    </div><br>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div><br>
                    <div class="" style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:
                      <textarea class=" reason"  name="reason" value="" id="reason" rows="1" style="width:100%;">{{$response->reason}}</textarea>
                    </div><br><br>
                    <div class="col-sm-12 row" >
                   Referred by:<br>
                      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 25%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-right:20%">
                        {{$doctor->FirstName}} {{$doctor->MiddleName}} {{$doctor->LastName}} 
                    </span>
                    </div>
                     <div class="for"  style="color:black;margin-left:90px">
                    Signature over Printed Name
                  </div>
                    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                    </div>
                    <div class="col-12  d-flex justify-content-center" >
                      <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;margin-right:30px">
                      <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Return Slip</div>
                    </div>
                    <div class="col-sm-12" style="text-align: right">
                      Course:
                      <input  class="course cert " name="" type="text" value="{{$course->accro}}" id="" style="width:10%">
                    </div>
                    <div class="col-sm-12" style="text-align: right">
                      School Year:
                      <input  class="cert" name="" type="text" value="{{$addYear}}" id="fullname" style="width:10%">
                    </div>
                      Date:
                      <input  class="col-1  cert" name="" type="text" value="" id="" ><br><br>
                    <div class="form-group col-sm-12" >
                      <div class="row"> 
                        Name:
                        <input  class=" cert lastname" type="text" value="{{$response->lastname}}" id="lastname" style="width:21%; text-align:center">&nbsp;
                        <input  class=" cert firstname" type="text" value="{{$response->firstname}}" id="firstname" style="width:20%; text-align:center">&nbsp;
                        <input  class=" cert middlename" type="text" value="{{$response->middlename}}" id="middlename" style="width:20%; text-align:center">
                        Age:
                        <input  class="cert age" type="text" value="{{$age}}" id="age" style="width:9.5%;text-align:center">
                        Gender:
                        <input  class=" cert gender" type="text" value="{{$response->gender}}" id="gender" style="width:15.5%;text-align:center">
                        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                        </div>
                      </div>
                      <div class="row">
                        Boarding House Address:
                        <input  class=" cert bhAddress" type="text" value="{{$response->b_brgy}}, {{$response->b_city}}, {{$response->b_province}}" id="bhAddress" style="width:55%">
                        Student Contact No.:
                        <input  class=" cert contactNo" type="text" value="{{$response->ContactNo}}" id="contactNo" style="width:15.9%">
                      </div>
                    </div>
                    <div class="form-group row col-12">
                      <div class=" d-flex justify-content-left" style="font-weight: 700; font-size: 15px; font-style: bold;">Action taken/Remarks:</div>
                        <table class=" table">
                          <tr >
                              <td class="col-sm-12 a " height="100px"><br><br><br><br>
                                <div style="text-align: right;">
                                <input  class=" cert " name="" type="text" value="" id="" style="width:22%;text-align:center">
                              </div>
                              Signature over Printed Name&emsp;
                            </td>
                          </tr>
                        </table>
                    </div>
                    <div class="row footer-end">
                      <br><br><br>
                      <div class="col-12  d-flex justify-content-center" >
                        <img src="{{asset('images/logo/sq_star.png')}}" style="width: 300px; height: 110px">
                        <img src="{{asset('images/logo/socotec.png')}}" style="width: 180px; height: 95px;">
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
              <form action="/approval" method="POST" id="pendingSlip">
              @csrf
                <button type="submit" style="background-color: white; height:40px;" class="col-md-12 btn btn-primary button">Submit</button>
                <input class="col-11 id" type="hidden" name="id" value="{{$encryptedId}}" id="id">
                <input class="col-11 id" type="hidden" value="{{$response->patientId}}" id="patientId">
                <input class="form-control" name="role" type="hidden" value="{{$role}}" id="" >
                <input class="col-11" type="hidden" name="status" value="Pending">
              </form>
            </div><hr>
            <div style="display: flex; flex-direction: column;">
              <button type="button" id="backbutton" style="background-color: white;" class=" btn btn-secondary button">Back</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    @else
      <div class="card-panel red lighten-3">
        <span class="white-text">{{ session('error') }}</span>
      </div>
    @endif
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
        $("#backbutton").click(function(){
          window.history.back();
      })
})
//Back button
 $(document).ready(function(){
        $("#backBTN").click(function(){
          window.history.back();
      })
})
    
$("#pendingSlip").submit(function(e) {
      e.preventDefault();
      var form = $(this);
      var actionUrl = form.attr('action');
      var id = $('#id').val();
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
                  confirmButtonText: 'Okay',
                }).then((response1) => {
                
                if (response1.isConfirmed) {
                  console.log(response.role);
                var role = response.role;
                if (role === 'Student') {
                  window.location.href = "/referral-status-slip?to_id=" +  encodeURIComponent(response.newID) + "&role=Student";
                } else if (role === 'Employee') {
                  window.location.href = "/referral-status-slip?to_id=" + encodeURIComponent(response.newID) + "&role=Employee";
                }
                }
              })
            }
          }
              
        });
      });

</script>
@endsection