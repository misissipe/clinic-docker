<?php
  use App\Http\Controllers\MedClientAddController;
  $mc = new MedClientAddController();
?>

@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Assessment Questionnaire')
@php
use App\Http\Controllers\AESCipher;
@endphp 
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<style>
   table, td {
  border: 1px solid rgb(195, 195, 195);
  border-collapse: collapse;
  padding: 3px;
  text-align: center;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  .alert {
  padding: 20px;
  background-color: #ff7f76;
  color: white;
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
 .cert{
    outline: 0;
    border-width: 0 0 0px;
    border-color: rgb(58, 57, 57)
  }
   .cert2{
  outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table --> 
<section id="basic-datatable">
  <div class="row">
    <div class="col-md-3">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-body mt-0 p-1">
              <ul class="nav nav-tabs border-0" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="print-tab" data-toggle="tab" href="#print" aria-controls="print" role="tab"aria-selected="false" style="display : none">
                    <i class="bx bx-calendar-event align-middle"></i>
                    <span class="align-middle">Print Health History</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="show-tab" data-toggle="tab" href="#show" aria-controls="show" role="tab"aria-selected="true" style="display : none">
                    <i class="bx bxs-bookmark-star align-middle"></i>
                    <span class="align-middle"></span>
                    </a>
                  </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane " id="print" aria-labelledby="print-tab" role="tabpanel">
                  <div class="table-responsive">
                    <div class="col-sm-12">
                      <div id="printPart">
                        <div class="col-12  d-flex justify-content-center" >
                          @php
                          $campus_code = session('campus');
                          @endphp
                          @if($campus_code == 1)<img class="logo" src="images/logo/main-campus-logo.png" alt="" style="width: 450px; height: 150px;margin-right:30px">@endif
                          @if($campus_code == 2)<img class="logo" src="images/logo/maasin-logo.png" alt="" style="width: 450px; height: 150px;margin-right:30px">@endif
                          @if($campus_code == 3)<img class="logo" src="images/logo/tomas-oppus.png" alt="" style="width: 450px; height: 150px;margin-right:30px">@endif
                          @if($campus_code == 4)<img class="logo" src="images/logo/bontoc.png" alt="" style="width: 450px; height: 150px;margin-right:30px">@endif
                          @if($campus_code == 5)<img class="logo" src="images/logo/san-juan.png" alt="" style="width: 450px; height: 150px;margin-right:30px">@endif
                          @if($campus_code == 6)<img class="logo" src="images/logo/hinunangan.png" alt="" style="width: 450px; height: 150px;margin-right:30px">@endif
                          <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 120px; height: 120px;">
                        </div>
                        <div class="row">
                          <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 15px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12 d-flex align-items-center" style="font-weight: 700; font-size: 20px; color: black;">
                            <div style="flex: 1; text-align: center;">
                              Patient Health Record Form
                            </div>
                            <div style="display: inline-block; width: 80px; height: 100px; border: 1px solid black; text-align: center; margin-left: 10px;">
                              <img src="path_to_id_picture" alt="ID Picture" style="max-width: 90%; max-height: 80%; object-fit: cover;" />
                            </div>
                          </div>
                        </div>
                       <table class="table" style="color:black;">
                            <tr>
                              <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="font-weight: 650; font-size: 12px; font-style: bold;">PERSONAL INFORMATION</div>
                              </td>
                            </tr>
                            <tr >
                              <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Name:
                                    <input  class="col-10 fullname cert name=" type="text" value="" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="1" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Date of birth:
                                    <input  class="col-7 bday cert" name="bday" type="text" value="" id="bday" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly> 
                                  </div> 
                                </div>
                              </td>
                              <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Weight:
                                    <input  class="col-7 weight cert" name="weight" type="text" value="" id="weight" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                              </td>
                              <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Height:
                                    <input  class="col-7 height cert" name="height" type="text" value="" id="height" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Blood Type:
                                    <input  class="col-5 bloodtype cert" name="bloodtype" type="text" value="" id="bloodtype" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div>  
                                </div>
                              </td>
                              <td colspan="1" style="border:1px solid rgb(0, 0, 0);">
                                    <div style="text-align: left">
                                      <div style="font-weight: 400; font-size: 12px;">Allergies:
                                        <input  class="col-7 allergies cert" name="allergies" type="text" value="" id="allergies" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                      </div> 
                                    </div>
                                </td>
                                <td style="border:1px solid rgb(0, 0, 0);">
                                  <div style="text-align: left">
                                    <div style="font-weight: 400; font-size: 12px;">Medication:
                                      <input  class="col-7 medication cert" name="medication" type="text" value="" id="medication" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                    </div> 
                                  </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Address:
                                    <input  class="col-10 address cert" name="" type="text" value="" id="address" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                              </td>
                            </tr>
                            <tr>
                              
                              <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Blood Pressure:
                                    <input  class="col-5 bp cert" name="" type="text" value="" id="bp" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly> 
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                         
                        <div class="row footer-end">
                          <div class="col-12  d-flex justify-content-end" >
                            <div class="column" style="margin-right:80px;margin-top:15px"> 
                            
                              <div class="d-flex justify-content-left" style="font-size: 20px;color:black;">Doc. Code SLSU-QF-MD02</span></div>
                              <div class=" d-flex justify-content-left" style="font-size: 20px;color:black;">Revision: 02</div>
                              <div class=" d-flex justify-content-left" style="font-size: 20px;color:black;">Date: 08 April 2022</div>
                            </div>
                            <img src="{{asset('images/logo/sq_star.png')}}" style="width: 350px; height: 120px;margin-right:50px">
                            <img src="{{asset('images/logo/socotec.png')}}" style="width: 230px; height: 100px;margin-right:70px;margin-top:15px">
                          </div>
                       </div>
                     </div>
                    </div>
                  </div>
                </div>
{{-- SHOW-TAB --}}
                  <div class="tab-pane active" id="show" aria-labelledby="show-tab" role="tabpanel">
                    <div class="table-responsive">
                      <div class="col-sm-12">
                        {{-- @if (isset($course))
                        @if ($healthHistory === null) --}}
                        <form action="{{ route('assessment.save') }}" method="post" id="saveForm">
                        @csrf
                          <input type="hidden" class=" col-sm-8 border-0 patientId" name="patientId" value="{{$data->StudentNo}}" id="id" style="font-weight:400;color:rgb(58, 57, 57)" >
                        <div class="row" >
                          <div class="col-12"  style="color:#000000;font-weight:bold;font-size:12px">
                            <button type="button" class="btn btn-success btnPrint float-right" data-id="" data-cert-id="" id="btnPrint" ><i class="fa fa-print"></i></button>
                            <br>
                            <h6 style="color:#000000;font-weight:bold">Personal Data</h6>
                            <hr>
                            <div class="form-group">
                              Name: <br><label class="" id="fname" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;">{{$data->FirstName}} {{$data->MiddleName}} {{$data->LastName}}</label><br>
                              Age: <br><label class="" id="age" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;">{{$age}}</label><br>
                              Gender: <br><label class="" id="gender" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;">{{$gender}}</label><br>
                              {{-- BloodType: <br><input type="text" class="form-control col-md-3 bloodtype" id="bloodtype" style="background-color:rgb(110, 155, 222); color:lightyellow;" name="bloodtype" value="{{$bloodtype ?? ''}}" placeholder=""> --}}
                              <hr>
                              DOB: <br><label class="" id="dob" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;">{{$data->BirthDate}}</label><br>
                              Contact No.: <br><label class="" id="civil" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;">{{$data->ContactNo}}</label><br>
                              Nationality: <br><label class="" id="nationality" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;">{{$data->nationality}}</label><br>
                              Address: <br>
                              Brgy:
                              <br><label class="" id="religion" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;"></label>
                              <br> City: 
                              <br><label class="" id="religion" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;"></label>
                              <br>Province: 
                              <br><label class="" id="religion" style="text-transform: capitalize;font-size:16px;color:rgb(0, 0, 0);font-style:italic;"></label>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 
    <div class="col-md-7 ">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-body mt-0 p-1"> 
              <h3 style="text-align:center; font-weight:bold;">Assessment Questionnaire of Potential Risk Factors for Viral/Bacterial Infection</h3>
               <table class="table" style="color:black;">
                  <tr>
                    <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                      <div style="font-weight: 650; font-size: 16px; font-style: bold;">RISK FACTOR QUESTIONNAIRE</div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Please indicate if you have the following symtoms:</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="border:1px solid rgb(0, 0, 0);">
                     <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group text-left">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Fever&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">  
                        <div class="form-group text-left">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Sore Throat&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12"> 
                        <div class="form-group text-left">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;margin-right:30%" for="smoking">Cough&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group text-left">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;margin-right:25%" for="smoking">Runny nose&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group text-left">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;margin-right:20%" for="smoking">Shortness of Breath&nbsp;</label>
                        </div>
                      </div>
                    </div>                                      
              </td>
                <td style="border:1px solid rgb(0, 0, 0);">
              <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group text-left">
               
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Fever">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Fever">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                       
                        <div class="form-group text-left">
                  
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_SoreThroat">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_SoreThroat">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        
                        <div class="form-group text-left">
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Cough">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Cough">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                       
                        <div class="form-group text-left">
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Cold">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Cold">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        
                        <div class="form-group text-left">
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_SOB">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_SOB">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                      </div>
                    </div> 
                  </td>  
                  </tr>
                  <tr>
                    <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Other symptoms:</label><br>
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Chills&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                        <br>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Chills">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Chills">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    <tr>
                    <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Nausea&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                       
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Nausea">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Nausea">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Diarrhea&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                       
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Diarrhea">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Diarrhea">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">headaches&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Headache">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Headache">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Joint aches&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                       
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_JointAches">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_JointAches">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Muscle aches&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                        
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_MuscleAches">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_MuscleAches">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">General Malaise&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                      
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_GenMal">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_GenMal">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Loss of Appetite&nbsp;</label>
                    </td>
                   <td style="border:1px solid rgb(0, 0, 0);">
                      <div class="form-group text-left">
                       
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_LossApp">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_LossApp">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                     <td style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Allergies &nbsp;</label><br>
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">If yes, please specify: &nbsp;</label>
                    </td>
                     <td style="border:1px solid rgb(0, 0, 0);">
                       
                      <div class="form-group text-left">
                       
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="yes_Allergy">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Yes&nbsp;</label>
                          <input type="checkbox" id="smoking" name="risk_factors[]" value="no_Allergy">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">No&nbsp;</label>
                       <br>
                        <input class="cert2 risk_other" type="text" id="risk_other" name="risk_other" value="" style="width: 55%">
                       
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Other symptoms not included in the list: &nbsp;</label>
                    
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border:1px solid rgb(0, 0, 0);text-align:left">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">(Please specify): &nbsp;</label>
                       <input class="cert2 others" type="text" id="others" name="others" value="" style="width: 55%">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border:1px solid rgb(0, 0, 0);text-align:left">
                    <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="temp">Temperature:</label>
                    <input class="cert2 othersFamhis" type="text" id="othersFam" name="temp" value="" style="width: 20%:margin-left:20px">
                    <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px; " for="pulse_rate">BP:</label>
                    <input class="cert2 othersFamhis" type="text" id="othersFam" name="bp" value="" style="width: 20%"><br>
                    <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="pulse_rate">Pulse Rate:</label>
                    <input class="cert2 othersFamhis" type="text" id="othersFam" name="pulse_rate" value="" style="width: 20%:margin-left:20px">
                    <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px; " for="service_availed">Service(s) Availed:</label>
                    <input class="cert2 othersFamhis" type="text" id="othersFam" name="service_availed" value="" style="width: 20%">
                    </td>
                  </tr>
               </table>
               <div>
                  <button type="button" id="button" class="btn btn-default btn-custom float-right">Back</button>
                  <button type="submit" class="btn btn-primary btn-custom float-right" id="checkBtn">Save</button>
               </div>   
              </form>
            </div>
          </div>
        </div>
      </div>
    </div> 
    
     
    <div class="col-md-2">
          <div class="card">
            <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:170px;">
               <img class="img-fluid rounded-circle" src="{{ $mc->profilephoto(['StudentNo' => $data->StudentNo,'campus' => session('campus')]) }}" alt="profile photo" style="width: 150px; height: 150px; object-fit: cover;"
                 onerror="this.onerror=null; this.src='{{ $data->Sex === 'F' ? asset('images/logo/42101748.png') : asset('images/logo/43514861.png') }}'; this.classList.remove('rounded-circle'); this.style.width='150px'; this.style.height='150px';">
            </div>   
            <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
              <label style="font-size: 18px;" id="id">{{$role}} </label>
              <label style="font-size: 12px;" id="id"></label>
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
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
//Search-Input
 $(document).ready(function() {
  $("#submitBtn").submit(function(event) {
    event.preventDefault();
    var search = $('#searchInput').val();
      $.ajax({
        type:'post',
        url:'/add-patient',
        data:{search:search},

        success:function(data){
          $('#myTable').html(data);   
        } 
      })
    })
 });

//back
 $(document).ready(function(){
    $("#button").click(function(){
      window.history.back();
    });
 });

$(document).ready(function () {

    $("#saveForm").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr("action");

        var checked = $("input[name='risk_factors[]']:checked");

        // Validate risk factors
        if (checked.length === 0) {
            Swal.fire({
                title: "Error",
                text: "Please select at least one Risk Factor.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return false;
        }

        // Collect form data without duplicate risk factors
        var formData = form.serializeArray().filter(function (item) {
            return item.name !== "risk_factors[]";
        });

        // Add checked risk factors only once
        checked.each(function () {
            formData.push({
                name: this.name,
                value: this.value
            });
        });

        // Disable save button
        $("#checkBtn").prop("disabled", true).text("Saving...");

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: $.param(formData),
            dataType: "json",

            success: function (response) {

                if (response.status == 200) {
                    Swal.fire({
                        title: "Success",
                        text: response.success,
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.message || "Unable to save assessment.",
                        icon: "error"
                    });
                }
            },

            error: function (xhr) {
                console.log(xhr.responseText);

                Swal.fire({
                    title: "Error",
                    text: xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : "Something went wrong while saving.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            },

            complete: function () {
                $("#checkBtn").prop("disabled", false).text("Save");
            }
        });

    });

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
