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
 .cert {
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
    <div class="col-md-10">
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
                          <div class="row" style="margin-top: 10px;">
                            {{-- <div style="display: inline-block; width: 80px; height: 30px;"></div>  --}}
                            <div style="text-align: right; margin-left: auto;">
                              <div style="font-weight: 400; font-size: 14px; color: black;">Course:
                                <input class="col-4 course cert" name="" type="text" value="{{$course->accro}}" id="fullname" style="font-weight: 400; font-size: 14px; font-style: bold;">
                              </div>
                              <div style="font-weight: 400; font-size: 14px; color: black;">School Year:
                                <input class="col-4 cert" name="" type="text" value="{{$addYear}}" id="fullname" style="font-weight: 400; font-size: 14px; font-style: bold;">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 700; font-size: 18px; font-style: bold; text-align:center;color:black;"><u>PERSONAL DATA</u></div>
                          </div>
                          <div class=" col-md-12" style="color: #000000">
                            Name: <input  class="firstname cert" name="" type="text" value="{{$course->LastName}}" id="firstname" style="width:25%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center"> <input  class=" cert" name="middlename" type="text" value="{{$course->FirstName}}" id="middlename" style="width:25.5%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center"> <input  class="lastname cert" name="" type="text" value="{{$course->MiddleName}}" id="lastname" style="width:20.8%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                            Age: <input  class="age cert" name="" type="text" value="{{$age}}" id="age" style="width:5%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                            Gender: <input  class="gender cert" name="" type="text" value="{{$gender}}" id="gender" style="width:10%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                          </div>
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                            <span style="margin-left:14.5%">(Last)</span>
                          <span style="margin-left:22%">(First)</span>
                            <span style="margin-left:18.7%">(Middle)</span>
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Date of Birth: <input  class="bday cert" name="" type="text" value="{{$course->BirthDate}}" id="bday" style="width:20%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                            Civil Status: <input  class="civil_status cert" name="" type="text" value="{{$course->civil_status}}" id="civil_status" style="width:14%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                            Nationality: <input  class="nationality cert" name="" type="text" value="{{$course->nationality}}" id="nationality" style="width:15%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                            Religion: <input  class="religion cert" name="" type="text" value="{{$course->religion}}" id="religion" style="width:20%;font-weight: 400; font-size: 14px; font-style: bold;text-align:center">
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Home Address: <input  class="fullname cert" name="" type="text" value="{{$course->p_street}}, {{$course->p_municipality}} {{$course->p_province}}" id="fullname" style="width:90.4%;font-weight: 400; font-size: 14px; font-style: bold;text-transform:capitalize;">
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Father's Name: <input  class="father_name cert" name="" type="text" value="{{$course->father_name}}" id="father_name" style="width:40.2%;font-weight: 400; font-size: 14px; font-style: bold;">
                            Mother's Name: <input  class="mother_name cert" name="" type="text" value="{{$course->mother_name}}" id="mother_name" style="width:39.6%;font-weight: 400; font-size: 14px; font-style: bold;">
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Occupation: <input  class="father_occu cert" name="" type="text" value="{{$course->father_occu}}" id="father_occu" style="width:42%;font-weight: 400; font-size: 14px; font-style: bold;">
                            Occupation: <input  class="mother_occu cert" name="" type="text" value="{{$course->mother_occu}}" id="mother_occu" style="width:42%;font-weight: 400; font-size: 14px; font-style: bold;">
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Office Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:40.1%;font-weight: 400; font-size: 14px; font-style: bold;">
                            Office Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:40.1%;font-weight: 400; font-size: 14px; font-style: bold;">
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Guardian: <input  class="emer_name cert" name="" type="text" value="{{$course->emer_name}}" id="emer_name" style="width:43.3%;font-weight: 400; font-size: 14px; font-style: bold;">
                            Parent's/Guardian Contact No.:<input  class="fullname cert" name="" type="text" value="{{$course->emer_contact}}" id="fullname" style="width:30.43%;font-weight: 400; font-size: 14px; font-style: bold;">
                          </div>
                          <div class="col-md-12" style="color: #000000">
                            Guardian Address: <input  class="emer_street cert" name="" type="text" value="{{$course->emer_street}}, {{$course->emer_city}} {{$course->emer_province}}" id="emer_street" style="width:38.2%;font-weight: 400; font-size: 12px; font-style: bold;">
                            Student's Contact No.: <input  class="fullname cert" name="" type="text" value="{{$course->ContactNo}}" id="fullname" style="width:36%;font-weight: 400; font-size: 14px; font-style: bold;">
                          </div>
                     
                          <div class="line" style="border-bottom: 1px solid rgb(0, 0, 0);margin:3px;margin-top:10px"></div>
                          <div class="line" style="border-bottom: 1px solid rgb(0, 0, 0);margin:3px"></div>
                          <h6 style="text-align:center; font-weight:bold;;color:black;">PLEASE CHECK THE BOX IF ONE OF THE FOLLOWING IS APPLICABLE</h6>
                          <div class="title">
                              <h6 style="text-decoration: underline; text-align:center;font-weight: bold;color:black;">MEDICAL AND SOCIAL HEALTH HISTORY</h6>
                          </div>
                            {{-- Family Health History --}}
                            <table class="table table-sm">
                              <tr>
                                <td style="border:1px solid rgb(0, 0, 0);width:50%;">
                                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;">Family Health History:</div> 
                                  <div class="row" >
                                    <div class="col-sm-4">
                                      {{-- <h6 style="font-weight:500;">Family Health History:</h6> --}}
                                      <div class="form-group text-left">
                                        <input type="checkbox" id="cancer" name="family_his[]" value="Cancer">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="cancer">Cancer</label><br>
                                        <input type="checkbox" id="heart" name="family_his[]" value="Heart disease">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="heart">Heart disease</label><br>
                                        <input type="checkbox" id="hypertension" name="family_his[]" value="Hypertension">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="hypertension">Hypertension</label><br>
                                        <input type="checkbox" id="thyroid" name="family_his[]" value="Thyroid Disease">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="thyroid">Thyroid Disease</label><br>
                                        <input type="checkbox" id="tuberculosis" name="family_his[]" value="Tuberculosis">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="tuberculosis">Tuberculosis</label ><br>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group text-left">
                                        <input type="checkbox" id="diabetesmellitus" name="family_his[]" value="Diabetes_Mellitus">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="diabetesmellitus">Diabetes Mellitus</label><br>
                                        <input type="checkbox" id="mental" name="family_his[]" value="Mental Disorder">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="mental">Mental Disorder</label><br>
                                        <input type="checkbox" id="Asthma_FamHis" name="family_his[]" value="Asthma_FamHis">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Asthma_FamHis">Asthma</label><br>
                                        <input type="checkbox" id="convulsion" name="family_his[]" value="Convulsion">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="convulsion">Convulsion</label><br>
                                        <input type="checkbox" id="bleeding" name="family_his[]" value="Bleeding Dyscrasia">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="bleeding">Bleeding Dyscrasia</label><br>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">  
                                      <div class="form-group text-left">
                                        <input type="checkbox" id="eye" name="family_his[]" value="Eye Disorder">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehiceyele1">Eye Disorder</label><br>
                                        <input type="checkbox" id="skin" name="family_his[]" value="Skin Problem">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="skin">Skin Problem</label><br>
                                        <input type="checkbox" id="kidney" name="family_his[]" value="Kidney Problem">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="kidney">Kidney Problem</label><br>
                                        <input type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 12px;" for="gastrointestinal">Gastrointes Disease</label><br>
                                        <input type="checkbox" id="othersFam" name="family_his[]" value="othersFamhis">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehicle2">Others:</label>
                                        <input class="cert othersFamhis" type="text" id="othersFam" name="othersFamhis" value="{{$healthHistory->othersFamhis ?? ''}}" style="width: 55%" disabled>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td style="border:1px solid rgb(0, 0, 0);">
                                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;">Personal Social History:</div> 
                                  <div class="row">
                                    <div class="col-sm-10">
                                      <br>
                                      <div class="form-group text-left"><input type="checkbox" id="smoking" name="personal_his[]" value="Smoking">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Smoking&nbsp;(</label>
                                        <input class="cert" type="number" id="sticksPer" name="sticksPerDay" style="width: 10%" value="{{$healthHistory->sticksPerDay ?? ''}}" disabled>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="day">Sticks/day</label>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="year">for</label>
                                        <input class="cert" type="number" id="Years" name="forYears" value="{{$healthHistory->sticksPerDay ?? ''}}" style="width: 10%" disabled>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="year"> year/s)</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-10">
                                      <div class="form-group text-left"><br>
                                        <input type="checkbox" id="drinking" name="personal_his[]" value="Drinking">
                                        <label  style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="drinking">Drinking&nbsp;(</label>
                                        <input class="cert" type="number" id="shot" name="shotPerday" value="{{$healthHistory->shot ?? ''}}" style="width: 10%" disabled>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="shots">shot per</label>
                                        <input class="cert" type="number" id="beers" name="beerPerday" value="{{$healthHistory->shotPer ?? ''}}" style="width: 10%" disabled>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="shots">)</label>
                                        <br>
                                        <label  style="text-transform: capitalize;color:black;margin-left:17.1%;font-weight: 400; font-size: 14px;" for="drinking">(</label>
                                        <input class="cert" type="number" id="" name="shotPerday" value="{{$healthHistory->beer ?? ''}}" style="width: 10%" disabled>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="shots">beer per</label>
                                        <input class="cert" type="number" id="" name="shotPerday" value="{{$healthHistory->beerPer ?? ''}}" style="width: 10%" disabled>
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="shots">)</label>
                                      </div>
                                    </div>
                                  </div>                              
                                </td>
                              </tr>
                              <tr>
                                <td style="border: 1px solid rgb(0, 0, 0);">
                                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;">Personal Health History:</div> 
                                  <div class="row">
                                    <div class="col-sm-4">
                                      <div class="form-group text-left" >
                                        <div>
                                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;"><u>Past Illness</u></div>
                                        </div>
                                          <input type="checkbox" id="PrimaryComlex" name="past_illness[]" value="Primary Complex" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="PrimaryComlex" >Primary Complex</label><br>
                                          <input type="checkbox" id="ChickenPox" name="past_illness[]" value="Chicken Pox" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="ChickenPox" >Chicken Pox</label><br>
                                          <input type="checkbox" id="KidneyDisease" name="past_illness[]" value="Kidney Disease" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="KidneyDisease" >Kidney Disease</label><br>
                                          <input type="checkbox" id="TyphoidFever" name="past_illness[]" value="Typhoid Fever" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="TyphoidFever" >Typhoid Fever</label><br>
                                          <input type="checkbox" id="EarProblem" name="past_illness[]" value="Ear Problem" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="EarProblem" >Ear Problem</label><br>
                                          <input type="checkbox" id="HeartDisease" name="past_illness[]" value="Heart Disease" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="HeartDisease" >Heart Disease</label><br>
                                          <input type="checkbox" id="Leukemia" name="past_illness[]" value="Leukemia" style="color:black;">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Leukemia" >Leukemia</label><br>
                                      </div>
                                    </div> 
                                    <div class="col-sm-4 ">
                                      <div class="form-group text-left"><br>
                                          <input type="checkbox" id="Asthma_PastIll" name="past_illness[]" value="Asthma_PastIll">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Asthma_PastIll">Asthma</label><br>
                                          <input type="checkbox" id="Diabetic" name="past_illness[]" value="Diabetic">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Diabetic">Diabetic</label><br>
                                          <input type="checkbox" id="EyeDisorder" name="past_illness[]" value="Eye Disorder">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="EyeDisorder">Eye Disorder</label><br>
                                          <input type="checkbox" id="Pneumonia" name="past_illness[]"value="Pneumonia">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Pneumonia">Pneumonia</label><br>
                                          <input type="checkbox" id="Dengue" name="past_illness[]" value="Dengue">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Dengue">Dengue</label><br>
                                          <input type="checkbox" id="Measle" name="past_illness[]" value="Measless">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Measle">Measles</label><br>
                                          <input type="checkbox" id="Hepa" name="past_illness[]" value="Hepa">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Hepa">Hepatitis</label><br>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group  text-left"><br>
                                          <input type="checkbox" id="Rheumatic" name="past_illness[]" value="Rheumatic">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Rheumatic">Rheumatic</label><br>
                                          <input type="checkbox" id="MentalDisorder" name="past_illness[]" value="Mental Disorder">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="MentalDisorder">Mental Disorder</label><br>
                                          <input type="checkbox" id="SkinProblems" name="past_illness[]" value="Skin Problems">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="SkinProblems">Skin Problems</label><br>
                                          <input type="checkbox" id="Poliomyelitis" name="past_illness[]" value="Poliomyelitis">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Poliomyelitis">Poliomyelitis</label><br>
                                          <input type="checkbox" id="ThyriodDisorder" name="past_illness[]" value="Thyriod Disorder">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="ThyriodDisorder">Thyriod Disorder</label><br>
                                          <input type="checkbox" id="Anemia" name="past_illness[]" value="Anemia">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Anemia">Anemia</label><br>
                                          <input type="checkbox" id="Mumps" name="past_illness[]" value="Mumpss">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Mumps">Mumps</label>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td style="border:1px solid rgb(0, 0, 0);">
                                  <div class="row">
                                    <div class="col-sm-4">
                                      <div class="form-group text-left" >
                                        <div>
                                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;"><u>Present Illness</u></div>
                                        </div>
                                        <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="ChestPain">Chest Pain</label><br>
                                        <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Insomnia">Insomnia</label><br>
                                        <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="JointPains">Joint Pains</label><br>
                                        <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Dizziness">Dizziness</label><br>    
                                        <input type="checkbox" id="othersPre" name="present_illness[]" value="othersPreIll">        
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehicle2">Others:</label>
                                        <input class="cert othersPres" type="text" id="othersPre" name="othersPreIll" value="{{$healthHistory->othersPreIll ?? ''}}" style="width:55%" disabled>       
                                      </div>
                                    </div>
                                    <div class="col-sm-3 ">
                                      <div class="form-group text-left"><br>
                                        <input type="checkbox" id="Headeaches" name="present_illness[]" value="Headeaches">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Headeaches">Headeaches</label><br>
                                        <input type="checkbox" id="Indigestion" name="present_illness[]" value="Indigestion">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Indigestion">Indigestion</label><br>
                                        <input type="checkbox" id="Swollen" name="present_illness[]" value="Swollen Fest">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Swollen">Swollen Fest</label><br>
                                        <input type="checkbox" id="Weight" name="present_illness[]" value="Weight Loss">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Weight">Weight Loss</label><br>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group  text-left"><br>
                                        <input type="checkbox" id="Nuesea" name="present_illness[]" value="Nuesea Vomiting">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Nuesea">Nuesea/Vomiting</label><br>
                                        <input type="checkbox" id="Sore" name="present_illness[]" value="Sore Throat">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Sore">Sore Throat</label><br>
                                        <input type="checkbox" id="Frequent" name="present_illness[]" value="Frequent Urination">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Frequent">Frequent Urination</label><br>
                                        <input type="checkbox" id="Breathing" name="present_illness[]" value="Difficulty of Breathing">
                                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 13px;" for="Breathing">Difficulty of Breathing</label><br>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" style="border:1px solid rgb(0, 0, 0);font-size:18px;color:#000000;font-size:14px" class="text-left" >
                                  Do you have a history of hospitalization for serious illness, operation, fracture or injury? <input  class="fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 14px; font-style: bold;width:5%">If yes, please give details: <input  class="col-12 fullname cert" name="" type="text" value="{{$healthHistory->hos_detail ?? ''}}" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;"> <br>
                                  Are you taking any medicine regularly?<input  class="col-1 fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 14px; font-style: bold;">If yes, name of drug/s:<input  class="fullname cert" name="" type="text" value="{{$healthHistory->med_detail ?? ''}}" id="fullname" style="width:40.8%;font-weight: 400; font-size: 18px; font-style: bold;"><br>
                                  Are you allergic to any food or medicine?<input  class="col-1 fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 14px; font-style: bold;">If yes, specify:<input  class=" fullname cert" name="" type="text" value="{{$healthHistory->al_detail ?? ''}}" id="fullname" style="width:46.2%;font-weight: 400; font-size: 18px; font-style: bold;">
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" style="border:1px solid rgb(0, 0, 0);" class="text-left">
                                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;"><u>Immunization History:</u></div> 
                                    <div class="row">
                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <input type="checkbox" id="BGC" name="immunization_his[]" value="BGC">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="BGC">BGC</label><br>
                                          <input type="checkbox" id="chic" name="immunization_his[]" value="ChickenPox">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="chic">Chicken Pox</label><br>
                                          <input type="checkbox" id="COVID" name="immunization_his[]" value="COVID-19">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="COVID">COVID-19</label><br>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <input type="checkbox" id="Polio" name="immunization_his[]" value="Polio Vaccine">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Polio">Polio Vaccine I,II,III, Booster Dose</label><br>
                                          <input type="checkbox" id="DTP" name="immunization_his[]" value="DTP Vaccine">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="DTP">DTP I,II,II, Booster Dose</label><br>
                                          <input type="checkbox" id="others" name="immunization_his[]" value="othersImmu">        
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehicle2">Others:</label>
                                          <input class="cert othersImmu" type="text" id="others" name="othersImmu" value="{{$healthHistory->othersImmu ?? ''}}" style="width:70%" disabled>
                                        </div>
                                      </div>
                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="MumpsImmunization">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="MumpsImmu">Mumps</label><br>
                                          <input type="checkbox" id="MeaslesImmu" name="immunization_his[]" value="MeaslesImmu">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="MeaslesImmu">Measles</label><br>
                                        </div>
                                      </div>
                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <input type="checkbox" id="Typhoid" name="immunization_his[]" value="Typhoid">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Typhoid">Typhoid</label><br>
                                          <input type="checkbox" id="German" name="immunization_his[]" value="GermanMeasles">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="German">German Measles</label><br>
                                        </div>
                                      </div>
                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <input type="checkbox" id="hepatitis_A" name="immunization_his[]" value="hepatitis-A">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Hepatitis-A">Hepatitis A</label><br>
                                          <input type="checkbox" id="hepatitis_B" name="immunization_his[]" value="hepatitis-B">
                                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Hepatitis-B">Hepatitis B</label><br>
                                        </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" style="border:1px solid rgb(0, 0, 0);font-size:14px;color:#000000" class="text-left" >
                                  <div class="d-flex justify-content-left" style="font-weight: 500; font-size: 14px;color:black;font-style: italic;"> I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.</div> <br>
                                  <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:25%;font-weight: 400; font-size: 14px; font-style: bold;margin-right:30px;margin-left:40px"> <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:45%;font-weight: 400; font-size: 18px; font-style: bold;margin-right:50px;"> <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:15%;font-weight: 400; font-size: 18px; font-style: bold;">
                                  <label style="font-size:14px;text-transform: capitalize;color:black;margin-right:200px;margin-left:100px" for="Headeaches">Signature of Student</label> <label style="font-size:14px;text-transform: capitalize;color:black;margin-right:170px" for="Headeaches">Signature of Parent/Guardian over Printed Name</label> <label style="font-size:14px;text-transform: capitalize;color:black;" for="Headeaches">Date Signed</label>
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
                        <form  action="/updateStdentRecord" method="post" id="updateForm">
                        @csrf
                        <input type="text" class=" col-sm-8 border-0 id" name="patientId" value="{{(new AESCipher)->encrypt($course->StudentNo)}}" id="id" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="lastname" value="{{$course->LastName}}" id="lastname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="firstname" value="{{$course->FirstName}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="middlename" value="{{$course->MiddleName}}" id="middlename" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="gender" value="{{$gender}}" id="gender" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="bday" value="{{$course->BirthDate}}" id="bday" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="course" value="{{$course->course_title}}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="accro" value="{{$course->accro}}" id="accro" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="major" value="{{$course->course_major}}" id="major" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="StudentYear" value="{{$course->StudentYear}}" id="lastname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="ContactNo" value="{{$course->ContactNo}}" id="bday" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="civil_status" value="{{$course->civil_status}}" id="middlename" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="nationality" value="{{$course->nationality}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden> 
                        <input type="text" class=" col-sm-8 border-0 id" name="religion" value="{{$course->religion}}" id="religion" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="p_street" value="{{$course->p_street}}" id="p_street" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="p_municipality" value="{{$course->p_municipality}}" id="p_municipality" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="p_province" value="{{$course->p_province}}" id="p_province" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="father_name" value="{{$course->father_name}}" id="father_name" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="mother_name" value="{{$course->mother_name}}" id="mother_name" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="father_occu" value="{{$course->father_occu}}" id="father_occu" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="mother_occu" value="{{$course->mother_occu}}" id="mother_occu" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="emer_name" value="{{$course->emer_name}}" id="emer_name" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="emer_street" value="{{$course->emer_street}}" id="emer_street" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="emer_city" value="{{$course->emer_city}}" id="emer_city" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="emer_province" value="{{$course->emer_province}}" id="emer_province" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <input type="text" class=" col-sm-8 border-0 id" name="emer_contact" value="{{$course->emer_contact}}" id="emer_contact" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                         {{-- <input type="text" class=" col-sm-8 border-0 id" name="StudentStatus" value="1" id="StudentStatus" style="font-weight:400;color:rgb(58, 57, 57)" hidden> --}}
                        <input type="text" class=" col-sm-8 border-0 id" name="StudentStatus" value="{{$course->StudentStatus}}" id="StudentStatus" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <h5 style="text-align:center; font-weight:bold;">Assessment Questionnaire of Potential Risk Facctors for Viral/Bacterial Infection</h5>
                          <div class="title">
                              <h6 style="text-decoration: underline; text-align:center;font-weight: bold; font-style: italic;color:royalblue)">MEDICAL AND SOCIAL HEALTH HISTORY</h6>
                          </div>
                          {{-- Family Health History --}}
                          <div class="row" >
                            <div class="col-sm-2">
                              <h6 style="font-weight:500;">Family Health History:</h6>
                              <div class="form-group">
                                <input type="checkbox" id="cancer" name="family_his[]" value="Cancer">
                                <label for="cancer">Cancer</label><br>
                                <input type="checkbox" id="heart" name="family_his[]" value="Heart disease">
                                <label for="heart">Heart disease</label><br>
                                <input type="checkbox" id="hypertension" name="family_his[]" value="Hypertension">
                                <label for="hypertension">Hypertension</label><br>
                                <input type="checkbox" id="thyroid" name="family_his[]" value="Thyroid Disease">
                                <label for="thyroid">Thyroid Disease</label><br>
                                <input type="checkbox" id="tuberculosis" name="family_his[]" value="Tuberculosis">
                                <label for="tuberculosis">Tuberculosis</label><br>
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <br>
                                <input type="checkbox" id="diabetesmellitus" name="family_his[]" value="Diabetes_Mellitus">
                                <label for="diabetesmellitus">Diabetes Mellitus</label><br>
                                <input type="checkbox" id="mental" name="family_his[]" value="Mental Disorder">
                                <label for="mental">Mental Disorder</label><br>
                                <input type="checkbox" id="Asthma_FamHis" name="family_his[]" value="Asthma_FamHis">
                                <label for="Asthma_FamHis">Asthma</label><br>
                                <input type="checkbox" id="convulsion" name="family_his[]" value="Convulsion">
                                <label for="convulsion">Convulsion</label><br>
                                <input type="checkbox" id="bleeding" name="family_his[]" value="Bleeding Dyscrasia">
                                <label for="bleeding">Bleeding Dyscrasia</label><br>
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <br>
                                <input type="checkbox" id="eye" name="family_his[]" value="Eye Disorder">
                                  <label for="vehiceyele1">Eye Disorder</label><br>
                                  <input type="checkbox" id="skin" name="family_his[]" value="Skin Problem">
                                  <label for="skin">Skin Problem</label><br>
                                  <input type="checkbox" id="kidney" name="family_his[]" value="Kidney Problem">
                                  <label for="kidney">Kidney Problem</label><br>
                                  <input style="font-size: 10px" type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                                  <label for="gastrointestinal">Gastrointes Disease</label><br>
                                  <input type="checkbox" id="othersFamhisCheckbox" name="family_his[]" value="othersFamhis">
                                  <label for="vehicle2">Others:</label><br>
                                  <input class="form-control othersFamhis" type="text" id="othersFamhisInput" name="othersFamhis" value="{{$healthHistory->othersFamhis ?? ''}}" disabled>
                              </div>
                            </div>
                            <div class="col-sm-2" style="border-left: 1px solid rgb(207, 206, 206)" >
                              <div class="form-group">
                                <div>
                                  <h6 style="font-weight:500;">Personal Social History:</h6>
                                </div>
                                  <input type="checkbox" id="smokingCheckbox" name="personal_his[]" value="Smoking" >
                                  <label for="smoking">Smoking</label><br>
                                <div class="form-group w-50">
                                  <label for="day">sticks/day</label><br>
                                  <input class="form-control" type="number" id="sticksPerDayInput" name="sticksPerDay" value="{{$healthHistory->sticksPerDay ?? ''}}" disabled>
                                  <label for="year">for year/s</label><br>
                                  <input class="form-control" type="number" id="forYearsInput" name="forYears" value="{{$healthHistory->forYears ?? ''}}" disabled>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group"><br>
                                <input type="checkbox" id="drinkingCheckbox" name="personal_his[]" value="Drinking">
                                <label for="drinking">Drinking</label><br>
                                <div class="row align-items-center">
                                  <div class="col-md-3 form-group">
                                      <input class="form-control shotInput" type="number" id="shotInput" name="shot" value="{{$healthHistory->shot ?? ''}}" disabled>
                                  </div>
                                  <div class="col-md-3 text-center">
                                      <label for="for shot">Shot per</label>
                                  </div>
                                  <div class="col-md-3 form-group">
                                      <input class="form-control shotPerInput" type="number" id="shotPerInput" name="shotPer" value="{{$healthHistory->shotPer ?? ''}}" disabled>
                                  </div>
                              </div>
                              <div class="row align-items-center">
                                <div class="col-md-3 form-group">
                                    <input class="form-control beerInput" type="number" id="beerInput" name="beer" value="{{$healthHistory->beer ?? ''}}" disabled>
                                </div>
                                <div class="col-md-3 text-center">
                                    <label for="for shot">ber per</label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input class="form-control beerperInput" type="number" id="beerPerInput" name="beerPer" value="{{$healthHistory->beerPer ?? ''}}" disabled>
                                </div>
                            </div>                        
                              </div>
                            </div>
                          </div><hr>
{{-- Personal Health History --}}
                          <div>
                            <h6 style="font-weight:500;"> Personal Health History: </h6>
                          </div>
{{-- Past Illness --}}
                            <div class="row">
                              <div class="col-sm-2">
                                <div class="form-group">
                                  <div>
                                    <h6>Past Illness</h6>
                                  </div>
                                    <input type="checkbox" id="PrimaryComlex" name="past_illness[]" value="Primary Complex">
                                    <label for="PrimaryComlex">Primary Complex</label><br>
                                    <input type="checkbox" id="ChickenPox" name="past_illness[]" value="Chicken Pox">
                                    <label for="ChickenPox">Chicken Pox</label><br>
                                    <input type="checkbox" id="KidneyDisease" name="past_illness[]" value="Kidney Disease">
                                    <label for="KidneyDisease">Kidney Disease</label><br>
                                    <input type="checkbox" id="TyphoidFever" name="past_illness[]" value="Typhoid Fever">
                                    <label for="TyphoidFever">Typhoid Fever</label><br>
                                    <input type="checkbox" id="EarProblem" name="past_illness[]" value="Ear Problem">
                                    <label for="EarProblem">Ear Problem</label><br>
                                    <input type="checkbox" id="HeartDisease" name="past_illness[]" value="Heart Disease">
                                    <label for="HeartDisease">Heart Disease</label><br>
                                    <input type="checkbox" id="Leukemia" name="past_illness[]" value="Leukemia">
                                    <label for="Leukemia">Leukemia</label><br>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="form-group"><br>
                                    <input type="checkbox" id="Asthma_PastIll" name="past_illness[]" value="Asthma_PastIll">
                                    <label for="Asthma_PastIll">Asthma</label><br>
                                    <input type="checkbox" id="Diabetic" name="past_illness[]" value="Diabetic">
                                    <label for="Diabetic">Diabetic</label><br>
                                    <input type="checkbox" id="EyeDisorder" name="past_illness[]" value="Eye Disorder">
                                    <label for="EyeDisorder">Eye Disorder</label><br>
                                    <input type="checkbox" id="Pneumonia" name="past_illness[]"value="Pneumonia">
                                    <label for="Pneumonia">Pneumonia</label><br>
                                    <input type="checkbox" id="Dengue" name="past_illness[]" value="Dengue">
                                    <label for="Dengue">Dengue</label><br>
                                    <input type="checkbox" id="Measle" name="past_illness[]" value="Measless">
                                    <label for="Measle">Measles</label><br>
                                    <input type="checkbox" id="Hepa" name="past_illness[]" value="Hepa">
                                    <label for="Hepa">Hepatitis</label><br>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="form-group"><br>
                                    <input type="checkbox" id="Rheumatic" name="past_illness[]" value="Rheumatic">
                                    <label for="Rheumatic">Rheumatic</label><br>
                                    <input type="checkbox" id="MentalDisorder" name="past_illness[]" value="Mental Disorder">
                                    <label for="MentalDisorder">Mental Disorder</label><br>
                                    <input type="checkbox" id="SkinProblems" name="past_illness[]" value="Skin Problems">
                                    <label for="SkinProblems">Skin Problems</label><br>
                                    <input type="checkbox" id="Poliomyelitis" name="past_illness[]" value="Poliomyelitis">
                                    <label for="Poliomyelitis">Poliomyelitis</label><br>
                                    <input type="checkbox" id="ThyriodDisorder" name="past_illness[]" value="Thyriod Disorder">
                                    <label for="ThyriodDisorder">Thyriod Disorder</label><br>
                                    <input type="checkbox" id="Anemia" name="past_illness[]" value="Anemia">
                                    <label for="Anemia">Anemia</label><br>
                                    <input type="checkbox" id="Mumps" name="past_illness[]" value="Mumpss">
                                    <label for="Mumps">Mumps</label><br>
                                </div>
                              </div>
{{-- Present Illness --}}
                              <div class="col-sm-2" style="border-left: 1px solid rgb(207, 206, 206)" >
                                <div class="form-group">
                                  <div>
                                    <h6>Present Illness</h6>
                                  </div>
                                    <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                                    <label for="ChestPain">Chest Pain</label><br>
                                    <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                                    <label for="Insomnia">Insomnia</label><br>
                                    <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                                    <label for="JointPains">Joint Pains</label><br>
                                    <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                                    <label for="Dizziness">Dizziness</label><br>    
                                    <input type="checkbox" id="othersPreIllCheckbox" name="present_illness[]" value="othersPreIll">        
                                    <label for="vehicle2">Others:</label><br>
                                    <input class="form-control othersPres" type="text" id="othersPreIllInput" name="othersPreIll" value="{{$healthHistory->othersPreIll ?? ''}}" disabled>       
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="form-group"><br>
                                    <input type="checkbox" id="Headeaches" name="present_illness[]" value="Headeaches">
                                    <label for="Headeaches">Headeaches</label><br>
                                    <input type="checkbox" id="Indigestion" name="present_illness[]" value="Indigestion">
                                    <label for="Indigestion">Indigestion</label><br>
                                    <input type="checkbox" id="Swollen" name="present_illness[]" value="Swollen Fest">
                                    <label for="Swollen">Swollen Fest</label><br>
                                    <input type="checkbox" id="Weight" name="present_illness[]" value="Weight Loss">
                                    <label for="Weight">Weight Loss</label><br>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="form-group"><br>
                                    <input type="checkbox" id="Nuesea" name="present_illness[]" value="Nuesea Vomiting">
                                    <label for="Nuesea">Nuesea/Vomiting</label><br>
                                    <input type="checkbox" id="Sore" name="present_illness[]" value="Sore Throat">
                                    <label for="Sore">Sore Throat</label><br>
                                    <input type="checkbox" id="Frequent" name="present_illness[]" value="Frequent Urination">
                                    <label for="Frequent">Frequent Urination</label><br>
                                    <input type="checkbox" id="Breathing" name="present_illness[]" value="Difficulty of Breathing">
                                    <label for="Breathing">Difficulty of Breathing</label><br>
                                </div>
                              </div>
                            </div><hr>
                            <label for="hospitalization">Do you have a history of hospitalization for serious illness, operation, fracture, or injury?</label><br>
                            <input type="checkbox" id="hospitalization_checkbox" value="If yes, please give details" name="hospitalization">&nbsp;If yes, please give details
                            <input type="text" class="form-control hospitalization_details" id="hospitalization_details" name="hos_detail" value="{{$healthHistory->hos_detail ?? ''}}" placeholder="" disabled><br>
                            <label for="medicine">Are you taking any medicine regularly?</label><br>
                            <input type="checkbox" id="medicine_checkbox" value="If yes, name of drug/s"name="medicine_mnt">&nbsp;If yes, name of drug/s
                            <input type="text" class="form-control medicine_details" id="medicine_details" name="med_detail" value="{{$healthHistory->med_detail ?? ''}}" placeholder="" disabled><br>
                            <label for="allergies">Are you allergic to any food or medicine?</label><br>
                            <input type="checkbox" id="allergies_checkbox" value="If yes, specify" name="allergies">&nbsp;If yes, specify
                            <input type="text" class="form-control allergies_details" id="allergies_details" name="al_detail" value="{{$healthHistory->al_detail ?? ''}}" placeholder="" disabled><br><hr> 
{{-- Immunization History --}}
                              <div>
                              <h6 style="font-weight:500;">Immunization History<span class="text-danger">*</span>:</h6>
                              </div>
                              <div class="row">
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <input type="checkbox" id="BGC" name="immunization_his[]" value="BGC">
                                    <label for="BGC">BGC</label><br>
                                    <input type="checkbox" id="chic" name="immunization_his[]" value="ChickenPox">
                                    <label for="chic">Chicken Pox</label><br>
                                    <input type="checkbox" id="COVID" name="immunization_his[]" value="COVID-19">
                                    <label for="COVID">COVID-19</label><br>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input type="checkbox" id="Polio" name="immunization_his[]" value="Polio Vaccine">
                                    <label for="Polio">Polio Vaccine I,II,III, Booster Dose</label><br>
                                    <input type="checkbox" id="DTP" name="immunization_his[]" value="DTP Vaccine">
                                    <label for="DTP">DTP I,II,II, Booster Dose</label><br>
                                    <input type="checkbox" id="othersImmuCheckbox" name="immunization_his[]" value="othersImmu">        
                                    <label for="vehicle2">Others:</label><br>
                                    <input class="form-control othersImmu" type="text" id="othersImmuInput" name="othersImmu" value="{{$healthHistory->othersImmu ?? ''}}" disabled>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="MumpsImmunization">
                                    <label for="MumpsImmu">Mumps</label><br>
                                    <input type="checkbox" id="MeaslesImmu" name="immunization_his[]" value="MeaslesImmu">
                                    <label for="MeaslesImmu">Measles</label><br>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <input type="checkbox" id="Typhoid" name="immunization_his[]" value="Typhoid">
                                    <label for="Typhoid">Typhoid</label><br>
                                    <input type="checkbox" id="German" name="immunization_his[]" value="GermanMeasles">
                                    <label for="German">German Measles</label><br>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <input type="checkbox" id="hepatitis_A" name="immunization_his[]" value="hepatitis-A">
                                    <label for="Hepatitis-A">Hepatitis A</label><br>
                                    <input type="checkbox" id="hepatitis_B" name="immunization_his[]" value="hepatitis-B">
                                    <label for="Hepatitis-B">Hepatitis B</label><br>
                                  </div>
                                </div>
                              </div><hr>
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
          </div>
        </div>
      </div>
        </div>
        <div class="col-md-2">
          <div class="card">
            <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:170px;">
               <img class="img-fluid rounded-circle" src="{{ $mc->profilephoto(['StudentNo' => $course->StudentNo,'campus' => session('campus')]) }}" alt="profile photo" style="width: 150px; height: 150px; object-fit: cover;"
                 onerror="this.onerror=null; this.src='{{ $course->Sex === 'Female' || $course->Sex === 'F' ? asset('images/logo/42101748.png') : asset('images/logo/43514861.png') }}'; this.classList.remove('rounded-circle'); this.style.width='150px'; this.style.height='150px';">
            </div> 
            <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
              <label style="font-size: 18px;" id="id">{{$course->StudentNo}}</label>
              <label style="font-size: 12px;" id="id">{{$course->StudentStatus}}</label>
            </div>
          </div>   
          <div class="card">
            <div class="card-body" style="background-color:rgb(110, 155, 222);">
              <div class="row" >
                <div class="col-12"  style="color:#f5f2f2;font-weight:bold;font-size:12px">
                  <button type="button" class="btn btn-success btnPrint float-right" data-id="" data-cert-id="" id="btnPrint" ><i class="fa fa-print"></i></button>
                  <br>
                  <h6 style="color:#f5f2f2;font-weight:bold">Personal Data</h6>
                  <hr>
                    Course: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->accro}}</label><br>
                    Major: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->course_major}}</label><br>
                    Year: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->StudentYear}}</label>
                  <hr>
                  <div class="form-group">
                    First Name: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{utf8_decode($course->FirstName)}}</label><br>
                    Middle Name: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{utf8_decode($course->MiddleName)}}</label><br>
                    Last Name: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{utf8_decode($course->LastName)}}</label><br>
                    Age: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$age}}</label><br>
                    Gender: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$gender}}</label>
                    <hr>
                    DOB: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{ date('m-d-Y', strtotime($newbday))}}</label><br>
                    Civil Status: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->civil_status}}</label><br>
                    Nationality: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->nationality}}</label><br>
                    Religion: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->religion}}</label>
                  </div>
                  <hr>
                    Contact Number: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$course->ContactNo}}</label>
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

//Update
$("#updateForm").submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var actionUrl = form.attr('action');

  if (!$("input[name='immunization_his[]']:checked").length) {
    swal.fire({
      title: "Error",
      text: "Please select at least one Immunization History.",
      icon: "error",
      button: "OK",
    }).then(() => {
      event.preventDefault();
    });
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
              location.reload()
            }
          });
          console.log(response); 	
        }
      }
    });
  }
}); 


 //Family History
    const othersFamhis = "{{$healthHistory->othersFamhis ?? ''}}";
    const othersFamhisCheckbox = document.getElementById("othersFamhisCheckbox");
    const othersFamhisInput = document.getElementById("othersFamhisInput");

      if (othersFamhis) {
      othersFamhisCheckbox.checked = true;
      othersFamhisInput.disabled = false;
        }

    othersFamhisCheckbox.addEventListener("change", function() {
        if (this.checked) {
            othersFamhisInput.disabled = false;
        } else {
            othersFamhisInput.disabled = true;
            othersFamhisInput.value = '';
        }
    });

    //Present Illness
      const  othersPreIll = "{{$healthHistory-> othersPreIll ?? ''}}";
      const othersPreIllCheckbox = document.getElementById("othersPreIllCheckbox");
      const othersPreIllInput = document.getElementById("othersPreIllInput");

        if (othersPreIll) {
        othersPreIllCheckbox.checked = true;
        othersPreIllInput.disabled = false;
    }

      
      othersPreIllCheckbox.addEventListener("change", function() {
        if (this.checked) {
          othersPreIllInput.disabled = false;
        } else {
          othersPreIllInput.disabled = true;
          othersPreIllInput.value = '';
        }
      });

    //Immunization History
      const  othersImmu = "{{$healthHistory-> othersImmu ?? ''}}";
      const othersImmuCheckbox = document.getElementById("othersImmuCheckbox");
      const othersImmuInput = document.getElementById("othersImmuInput");

      if (othersImmu) {
      othersImmuCheckbox.checked = true;
      othersImmuInput.disabled = false;
      }
      
      othersImmuCheckbox.addEventListener("change", function() {
        if (this.checked) {
          othersImmuInput.disabled = false;
        } else {
          othersImmuInput.disabled = true;
          othersImmuInput.value = '';
        }
      });

    //Personal History
    const sticksPerDay = "{{$healthHistory->sticksPerDay ?? ''}}";
    const forYears = "{{$healthHistory->forYears ?? ''}}";
    const smokingCheckbox = document.getElementById("smokingCheckbox");
    const sticksPerDayInput = document.getElementById("sticksPerDayInput");
    const forYearsInput = document.getElementById("forYearsInput");
      
    if (sticksPerDay || forYears) {
          smokingCheckbox.checked = true;
          sticksPerDayInput.disabled = false;
          forYearsInput.disabled = false;
        }

        smokingCheckbox.addEventListener("change", function () {
          if (this.checked) {
            sticksPerDayInput.disabled = false;
            forYearsInput.disabled = false;
          } else {
            sticksPerDayInput.disabled = true;
            forYearsInput.disabled = true;
            sticksPerDayInput.value = '';
            forYearsInput.value = '';
          }
        }); 

//Drinking
    const shot = "{{$healthHistory->shot ?? ''}}";
    const shotPer = "{{$healthHistory->shotPer ?? ''}}";
    const beer = "{{$healthHistory->beer ?? ''}}";
    const beerPer = "{{$healthHistory->beerPer ?? ''}}";

    const drinkingCheckbox = document.getElementById("drinkingCheckbox");
    const shotInput = document.getElementById("shotInput");
    const shotPerInput = document.getElementById("shotPerInput");
    const beerInput = document.getElementById("beerInput");
    const beerPerInput = document.getElementById("beerPerInput");

      if (shot || shotPer || beer || beerPer) {
      drinkingCheckbox.checked = true;
      shotInput.disabled = false;
      shotPerInput.disabled = false;
      beerInput.disabled = false;
      beerPerInput.disabled = false;
    }

    drinkingCheckbox.addEventListener("change", function () {
      if (this.checked) {
        shotInput.disabled = false;
        shotPerInput.disabled = false;
        beerInput.disabled = false;
        beerPerInput.disabled = false;
      } else {
        shotInput.disabled = true;
        shotPerInput.disabled = true;
        beerInput.disabled = true;
        beerPerInput.disabled = true;
        shotInput.value = '';
        shotPerInput.value = '';
        beerInput.value = '';
        beerPerInput.value = '';
      }
    });

    //hospitatlization
      const hospitalization = "{{$healthHistory->hospitalization ?? ''}}";
      const hospitalizationCheckbox = document.getElementById('hospitalization_checkbox');
      const hospitalizationDetails = document.getElementById('hospitalization_details');

          if (hospitalization.includes(hospitalizationCheckbox.value)) {
        hospitalizationCheckbox.checked = true;
        hospitalizationDetails.disabled = false;
      }

      hospitalizationCheckbox.addEventListener("change", function() {
        if (this.checked) {
          hospitalizationDetails.disabled = false;
        } else {
          hospitalizationDetails.disabled = true;

          hospitalizationDetails.value = '';
        }
      });
    //maintenance
      const medicine_mnt = "{{$healthHistory->medicine_mnt ?? ''}}";
      const medicineCheckbox = document.getElementById('medicine_checkbox');
      const medicineDetails = document.getElementById('medicine_details');

        if (medicine_mnt.includes(medicineCheckbox.value)) {
        medicineCheckbox.checked = true;
        medicineDetails.disabled = false;
      }

      medicineCheckbox.addEventListener("change", function() {
        if (this.checked) {
          medicineDetails.disabled = false;
        } else {
          medicineDetails.disabled = true;

          medicineDetails.value = '';
        }
      });

    //allergies

      const allergies = "{{$healthHistory->allergies ?? ''}}";
      const allergiesCheckbox = document.getElementById('allergies_checkbox');
      const allergiesDetails = document.getElementById('allergies_details');

      if (allergies.includes(allergiesCheckbox.value)) {
        allergiesCheckbox.checked = true;
        allergiesDetails.disabled = false;
      }

      allergiesCheckbox.addEventListener("change", function() {
        if (this.checked) {
          allergiesDetails.disabled = false;
        } else {
          allergiesDetails.disabled = true;

          allergiesDetails.value = '';
        }
      });


        $(document).ready(function() {
        var family_his = "{{$healthHistory->family_his ?? ''}}";
        var past_illness = "{{$healthHistory->past_illness ?? ''}}";
        var present_illness = "{{$healthHistory->present_illness ?? ''}}";
        var personal_his = "{{$healthHistory->personal_his ?? ''}}";
        var immunization_his = "{{$healthHistory->immunization_his ?? ''}}";
        var hospitalization = "{{$healthHistory->hospitalization ?? ''}}";
        var medicine_mnt = "{{$healthHistory->medicine_mnt ?? ''}}";
        var allergies = "{{$healthHistory->allergies ?? ''}}";

        $("input:checkbox").each(function() {
          if (family_his.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (past_illness.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (present_illness.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (personal_his.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (immunization_his.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (hospitalization.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (medicine_mnt.includes($(this).val())) {
            $(this).prop("checked", true);
          }
        });

        $("input:checkbox").each(function() {
          if (allergies.includes($(this).val())) {
            $(this).prop("checked", true);
          }
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