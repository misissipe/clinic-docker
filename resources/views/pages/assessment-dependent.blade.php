@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Dental Management Information System')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .table {
  border: 1px solid rgb(195, 195, 195);
  border-collapse: collapse;
  padding: 3px;
  text-align: center;
  }
  .x-cell::before {
  content: "✕";
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  font-weight: bolder;
  color:rgb(0, 0, 0)
  }
  input{
    text-transform: capitalize ;
    color:rgb(58, 57, 57)
  }
  .border {
    border: 1px;
    color:rgb(58, 57, 57)
  }
  .align{
      text-align: center;
  }
  .move{
      text-align: left;
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
      margin: 10px;
      accent-color: rgb(58, 57, 57)
  }
  thead{
  background-color: rgb(110, 155, 222);
 }
 .head{
  background-color:rgba(110, 155, 222, 0);
 }
 .vl {
  border-left: 2px solid rgb(144, 140, 140);
  height: 230px;
  position: absolute;
  left: 50%;
  margin-left: -3px;
  top: 0;
 }
 select.form-select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background: url('path_to_custom_arrow_image.png') no-repeat; 
    background-position: right center;
    background-size: auto;
    padding-right: 20px;
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
  <div class="row">
    <div class="" style="width: 100%" >
      <div class="card border"  style="margin-bottom: 20px;">
        <div class="card-body" style="" >
          <div class="col-sm-12">
            <div class="row col-12" style="font-size:16px;font-weight:400;">
              Name:
              <input type="text" class=" fullname input" name=""  id=""  style="font-weight: bold;font-size:16px;width:58%;text-transform:capitalize;margin-left:4.7%" value="  {{ ucwords(strtolower(utf8_decode($record->FirstName)))}} {{ ucwords(strtolower(utf8_decode($record->MiddleName)))}} {{ ucwords(strtolower(utf8_decode($record->LastName)))}}" readonly>
              DoB:
              <input type="text" class=" col-sm-3  bday input" name=""  id="bday" style="font-weight: bold;font-size:16px;margin-left:1.6%" value="{{ date('m-d-Y', strtotime($newbday)) }}" readonly>
            </div> 
            <div class="row col-12" style="font-size:16px;font-weight:400;">
              Home Address:
              <input type="text" class=" col-sm-7  address input" name=""  id="address" style="font-weight: bold;font-size:16px;text-transform:capitalize;" value="{{ ucwords(strtolower(utf8_decode($record->p_street)))}}, {{  ucwords(strtolower(utf8_decode($record->p_municipality)))}}, {{ ucwords(strtolower(utf8_decode($record->p_province)))}}" readonly>
              Age:
              <input type="text" class=" col-sm-3  age input" name="age"  id="age" style="font-weight: bold;font-size:16px;margin-left:1.9%" value={{$age}} readonly>
            </div>
            <div class="row col-12" style=" font-size:16px;font-weight:400;">
              Course: &nbsp;
              <input type="text" class="  address input" name=""  id="address" style="font-weight: bold;font-size:16px;width:56.9%;margin-left:4.1%" value="{{$course->accro}} - {{$course->course_major}}" readonly>&nbsp;
              Gender:
              <input type="text" class=" age input" name="gender"  id="age" style="font-weight: bold;font-size:16px;width:15%;margin-left:1%" value={{$gender}} readonly>
              Date:
              <input class=" float-right date @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" style="font-weight: bold;width:10%;" required autocomplete="date" type="date" value="" id="date">
            </div>
            <div class="row col-12" style=" font-size:16px;font-weight:400;">
              Email Address: &nbsp;
              <input type="text" class=" " name=""  id="" style="font-weight: bold;font-size:16px;width:56.9%;margin-left:0.5%;text-transform:lowercase" value="{{ strtoLower($course->email)}}"  readonly>&nbsp;
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="" style="width: 20%">
      <div class="card border">
        <div class="card-body" style="background: rgb(110, 155, 222);color:white">
          <label for="cancer" style="text-transform: capitalize;font-size:20px;font-weight:bolder;color:white">Legend:</label>
          <div class=" form-group" >
          <br>
            <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Condition</label><br>
            <label for="cancer" style="text-transform: capitalize; font-size: 14px;color:white;"><b>D</b>- <i>Decayed (caries indicated for filing)</i></label><br>
            <label for="heart" style="text-transform: capitalize;font-size:14px;color:white"><b>M</b>- <i>Missing</i></label><br>    
            <label for="hypertension" style="text-transform: capitalize;font-size:14px;color:white"><b>F</b>- <i>Filled</i></label><br>                      
            <label for="thyroid" style="text-transform: capitalize;font-size:14px;color:white"><b>I</b>- <i>Caries indicated for Extration</i></label><br>                       
            <label for="tuberculosis" style="text-transform: capitalize;font-size:14px;color:white"><b>RF</b>- <i>Root Fragment</i></label><br>                  
            <label for="thyroid" style="text-transform: capitalize;font-size:14px;color:white"><b>MO</b>- <i>Missing due to Other Causes</i></label><br>                      
            <label for="tuberculosis" style="text-transform: capitalize;font-size:14px;color:white"><b>Im</b>- <i>Impacted Tooth</i></label>
          </div>
          <div class=" mx-auto">
            <div class="form-group">
              <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Restoration & Prosthetics</label><br>
              <label for="diabetes" style="text-transform: capitalize;font-size:14px;color:white"><b>J</b>- <i>Jacket Crown</i></label><br>                        
              <label for="mental" style="text-transform: capitalize;font-size:14px;color:white"><b>A</b>- <i>Amalgam Filling</i></label><br>                       
              <label for="asthma" style="text-transform: capitalize;font-size:14px;color:white"><b>AB</b>- <i>Abutment</i></label><br>                       
              <label for="convulsion" style="text-transform: capitalize;font-size:14px;color:white"><b>P</b>- <i>Pontic</i></label><br>                       
              <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>In</b>- <i>Inlay</i></label><br>                       
              <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>Fx</b>- <i>Fixed Cure Composite</i></label><br>                       
              <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>S</b>- <i>Sealant</i></label><br>                        
              <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>Rm</b>- <i>Removable Denture</i></label>
            </div>
          </div>
          <div class=" mx-auto">
            <div class="form-group">
              <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Surgery</label><br>
              <label for="vehiceyele1" style="text-transform: capitalize;font-size:14px;color:white"><b>X</b>- <i>Extraction due to Causes</i></label><br>
              <label for="skin" style="text-transform: capitalize;font-size:14px;color:white"><b>XO</b>- <i>Extraction due to Other Causes</i></label><br>
              <br>
              <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Others</label><br>
              <label for="gastrointestinal" style="text-transform: capitalize;font-size:14px;color:white"><b>✓</b>- <i>Present Teeth</i></label><br>
              <label for="vehicle2" style="text-transform: capitalize;font-size:14px;color:white"><b>Cm</b>- <i>Congenitally Missing</i></label><br>
              <label for="vehicle2" style="text-transform: capitalize;font-size:14px;color:white"><b>Sp</b>- <i>Supernumerary</i></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="" style="width: 78.6%;margin-left:20px">
      <div class="card border">
        <div class="card-body" >
          <h4 style="font-weight:700;text-align: center">DENTAL RECORD CHART</h4>
          <div class="table-responsive">
            <form action="/addNewDentalRec" method="POST" id="saveRecord"> 
            @csrf
              <input type="hidden" class=" col-sm-1 input " name="role"  id="role" style="" value="Student" >
              {{-- <input type="hidden" class=" col-sm-2 border-0 id" name="appointmentId"  id="id" style="font-weight: bold;" value={{$appointmentId}} readonly> --}}
              <input type="hidden" class=" col-sm-2 border-0 id" name="status"  id="id" style="font-weight: bold;" value="Created" readonly>
              <input type="hidden" class=" col-sm-1  date input" name="date"  id="date" style="font-weight: bold;font-size:16px;" value="" readonly>
              <input type="text" class=" col-sm-8 border-0 id" name="patientId" value="{{$record->StudentNo}}" id="id" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="lastname" value="{{$record->LastName}}" id="lastname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="firstname" value="{{$record->FirstName}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="middlename" value="{{$record->MiddleName}}" id="middlename" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="gender" value="{{$gender}}" id="gender" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="bday" value="{{$record->BirthDate}}" id="bday" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="course" value="{{$course->course_title}}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="accro" value="{{$course->accro }}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="poscourse" value="{{$course->accro }}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="major" value="{{$course->course_major }}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="StudentYear" value="{{$course->StudentYear}}" id="lastname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="ContactNo" value="{{$record->ContactNo}}" id="bday" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="civil_status" value="{{$record->civil_status}}" id="middlename" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="nationality" value="{{$record->nationality}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden> 
              <input type="text" class=" col-sm-8 border-0 id" name="religion" value="{{$record->religion}}" id="religion" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="p_street" value="{{$record->p_street}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="p_municipality" value="{{$record->p_municipality}}" id="middlename" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="p_province" value="{{$record->p_province}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="father_name" value="{{$record->father_name}}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="mother_name" value="{{$record->mother_name}}" id="middlename" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="father_occu" value="{{$record->father_occu}}" id="gender" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="mother_occu" value="{{$record->mother_occu}}" id="bday" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="emer_name" value="{{$record->emer_name}}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="emer_street" value="{{$record->emer_street}}" id="bday" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="emer_city" value="{{$record->emer_city}}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="emer_province" value="{{$record->emer_province}}" id="lastname" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <input type="text" class=" col-sm-8 border-0 id" name="emer_contact" value="{{$record->emer_contact}}" id="gender" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
              <h6 style="font-weight:700">INTRAORAL EXAMINATION</h6>
              <div class="" style="text-align: center">
                <h6 style="font-weight:700">DENTITION STATUS AND TREATMENT NEEDS</h6>
              </div>
              <div class="col-12 align" >
                <table class="" style="margin:auto;">
                  <thead class="head">
                    <tr>
                      <td colspan="3" style="border:none">Status</td>
                      @for($i = 0; $i < 10; $i++)
                      <td class="border border-dark">
                        <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="53" style="font-size: 14px; font-weight:bold;text-align:center;">
                          <option selected></option>
                          <?php
                            $legends = array("D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In","Fx","S","Rm","X","XO","✓","Cm","Sp");
                            foreach ($legends as $legend) {
                              $selected = (isset($issueDetails[$i]) && $issueDetails[$i] == $legend) ? 'selected' : '';
                              echo "<option value=\"$legend\" $selected>$legend</option>";
                            }
                          ?>
                        </select>
                      </td>
                      @endfor
                      <td colspan="3" style="border:none"></td>
                    </tr>
                    <tr>
                      <td colspan="3" style="border:none;font-weight:bold;">Right</td>
                        <?php for ($i = 55; $i >= 51; $i--) { ?>
                      <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                        <?php } ?>
                        <?php for ($i = 61; $i <= 65; $i++) { ?>
                      <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                        <?php } ?>
                      <td colspan="3" style="border:none;font-weight:bold;">Left</td>
                    </tr>
                    <tr>
                      <td colspan="3" style="border:none">Temporary Teeth</td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="img" /></td>
                      <td colspan="3" style="border:none"></td>
                    </tr>
                    <tr>
                      @php
                        $issueDetailsStartIndex = 10;
                        $issueDetailsEndIndex = 25;
                      @endphp

                      @foreach (range($issueDetailsStartIndex, $issueDetailsEndIndex) as $index)
                      <td class="border border-dark">
                        <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="54" style="font-size: 14px; font-weight:bold;">
                          <option selected></option>
                          @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                            <option value="{{ $legend }}" @if(isset($issueDetails[$index]) && $issueDetails[$index] == $legend) selected @endif>{{ $legend }}</option>
                          @endforeach
                        </select>
                      </td>
                      @endforeach
                    </tr>
                    <tr>
                      @php
                        $issueDetailsStartIndex = 26;
                        $issueDetailsEndIndex = 41;
                      @endphp
                  
                      @foreach (range($issueDetailsStartIndex, $issueDetailsEndIndex) as $index)
                      <td class="border border-dark">
                        <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="54" style="font-size: 14px; font-weight:bold;">
                          <option selected></option>
                          @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                            <option value="{{ $legend }}" @if(isset($issueDetails[$index]) && $issueDetails[$index] == $legend) selected @endif>{{ $legend }}</option>
                          @endforeach
                        </select>
                      </td>
                      @endforeach
                    </tr>
                    <tr>
                      <?php for ($i = 18; $i >= 11; $i--) { ?>
                        <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                      <?php } ?>
                      <?php for ($i = 21; $i <= 28; $i++) { ?>
                        <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                    </tr>
                    <tr>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                    </tr>
                    <tr>
                      <?php for ($i = 48; $i >= 41; $i--) { ?>
                        <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                      <?php } ?>
                      <?php for ($i = 31; $i <= 38; $i++) { ?>
                        <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      @php
                        $issueDetailsStartIndex = 42;
                        $issueDetailsEndIndex = 57;
                      @endphp
                      
                      @foreach (range($issueDetailsStartIndex, $issueDetailsEndIndex) as $index)
                      <td class="border border-dark">
                        <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="54" style="font-size: 14px; font-weight:bold;">
                          <option selected></option>
                          @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                            <option value="{{ $legend }}" @if(isset($issueDetails[$index]) && $issueDetails[$index] == $legend) selected @endif>{{ $legend }}</option>
                          @endforeach
                        </select>
                      </td>
                      @endforeach
                    </tr>
                    <tr>
                      @php
                        $issueDetailsStartIndex = 58;
                        $issueDetailsEndIndex = 73;
                      @endphp
                      
                      @foreach (range($issueDetailsStartIndex, $issueDetailsEndIndex) as $index)
                      <td class="border border-dark">
                        <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="54" style="font-size: 14px; font-weight:bold;">
                          <option selected></option>
                          @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                            <option value="{{ $legend }}" @if(isset($issueDetails[$index]) && $issueDetails[$index] == $legend) selected @endif>{{ $legend }}</option>
                          @endforeach
                        </select>
                      </td>
                      @endforeach
                    </tr>
                    <tr>
                      <td colspan="3" style="border:none">Temporary Teeth</td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td class="border border-dark"><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                      <td colspan="3" style="border:none"></td>
                    </tr>
                    <tr>
                      <td colspan="3" style="border:none;font-weight:bold;">Right</td>
                        <?php for ($i = 85; $i >= 81; $i--) { ?>
                          <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                        <?php } ?>
                        <?php for ($i = 71; $i <= 75; $i++) { ?>
                          <td class="border border-dark" style="font-weight:700;font-size:16px"><?php echo $i; ?></td>
                        <?php } ?>
                      <td colspan="3" style="border:none;font-weight:bold;">Left</td>
                    </tr>
                    <tr>
                      <td colspan="3" style="border:none">Status</td>
                        @for($i = 74; $i < 84; $i++)
                        <td class="border border-dark">
                          <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="{{ 55 - $i }}" style="font-size: 14px;font-weight:bold;">
                          <option selected></option>
                          <?php
                            $legends = array("D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In","Fx","S","Rm","X","XO","✓","Cm","Sp");
                            foreach ($legends as $legend) {
                            $selected = ($issueDetails[$i] ?? '') === $legend ? 'selected' : '';
                            echo "<option value=\"$legend\" $selected>$legend</option>";
                            }
                          ?>
                          </select>
                        </td>
                        @endfor
                      <td colspan="3" style="border:none"></td>
                    </tr>                    
                  </thead>
                </table>
              </div><br>
              <div class="row col-md-12">
             {{-- <div class="vl"></div> --}}
                <div class="form-group">
                <br>
                  &emsp;&emsp;<label for="cancer" style="text-transform: capitalize;font-size:18px;font-weight:bold">Periodontal Screening:</label><br>
                  &emsp;&emsp;<input type="checkbox" id="Gingivits " name="periodontal[]" value="Gingivits">
                  <label for="cancer" style="text-transform: capitalize;font-size:14px">Gingivits</label><br>
                  &emsp;&emsp;<input type="checkbox" id="vehicle1" name="periodontal[]" value="Early Periodontitis">
                  <label for="heart" style="text-transform: capitalize;font-size:14px">Early Periodontitis</label><br>
                  &emsp;&emsp;<input type="checkbox" id="vehicle1" name="vehicle1" value="Moderate Periodontitis">
                  <label for="hypertension" style="text-transform: capitalize;font-size:14px">Moderate Periodontitis</label><br>
                  &emsp;&emsp;<input type="checkbox" id="vehicle1" name="periodontal[]" value="Advance Periodontitis">
                  <label for="thyroid" style="text-transform: capitalize;font-size:14px">Advance Periodontitis</label><br>
                </div>
                <div class=" mx-auto">
                  <div class="form-group">
                    <br>
                    <label for="cancer" style="text-transform: capitalize;font-size:18px;font-weight:bold">Occlusion:</label><br>
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Class Molar">
                    <label for="diabetes" style="text-transform: capitalize;font-size:14px">Class(Molar)</label><br>
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Overjet">
                    <label for="mental" style="text-transform: capitalize;font-size:14px">Overjet</label><br>
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Overbite">
                    <label for="asthma" style="text-transform: capitalize;font-size:14px">Overbite</label><br>     
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Midline Deviation">                  
                    <label for="convulsion" style="text-transform: capitalize;font-size:14px">Midline Deviation</label><br>  
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Crossbite"> 
                    <label for="bleeding" style="text-transform: capitalize;font-size:14px">Crossbite</label><br>
                  </div>
                </div>
                <div class="form-group">
                  <br>
                  <label for="cancer" style="text-transform: capitalize;font-size:18px;font-weight:bold">Appliances:</label><br>
                  <input type="checkbox" id="vehicle1" name="appliances[]" value="Orthodontic">
                  <label for="vehiceyele1" style="text-transform: capitalize;font-size:14px">Orthodontic</label><br>
                  <input type="checkbox" id="vehicle1" name="appliances[]" value="Stayplate">
                  <label for="skin" style="text-transform: capitalize;font-size:14px">Stayplate</label><br>
                  <input type="checkbox" id="othersApp" name="appliances[]" value="Others">
                  <label for="vehicle2" style="text-transform: capitalize;font-size:14px">Others</label><br>
                  <input class="form-control othersApp" type="text" id="othersApp" name="othersApp" value="" disabled>
                </div>
                <div class="mx-auto">
                  <div class="form-group">
                    <br>
                    <label for="cancer" style="text-transform: capitalize;font-size:18px;font-weight:bold">TMD:</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Clenching">
                    <label for="diabetes" style="text-transform: capitalize;font-size:14px">Clenching</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Clicking">
                    <label for="mental" style="text-transform: capitalize;font-size:14px">Clicking</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Trismus">
                    <label for="asthma" style="text-transform: capitalize;font-size:14px">Trismus</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Muscle Spasm"> 
                    <label for="convulsion" style="text-transform: capitalize;font-size:14px">Muscle Spasm</label>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <button type="button" id="cancelBtn" class="btn btn-default btn-custom float-right">Cancel</button>
              <button type="submit" class="btn btn-primary btn-custom float-right" id="checkBtn">Next</button>
            </div>
          </div>
        </form>
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
   
// Date
var today = new Date().toISOString().split('T')[0];
document.getElementById('date').setAttribute('max', today);
// cancel
$(document).ready(function(){
        $("#cancelBtn").click(function(){
          window.history.back();
      })
    })
// Modal
$(document).ready(function() {
  $('.viewModal').click(function() {
    var patientId = $(this).attr('patientId');
    var toothId = $(this).attr('toothId');
    
    $.ajax({
      url: '/view-modal',
      type: 'POST',
      data: { 
          patientId: patientId,
          toothId: toothId
      },
      success: function(response) {
        console.log(response);
        $('#treatmentRecord').modal('show')
        console.log(response.patientId);
        $('.teethId').val(response.toothId);
        $('.patientId').val(response.patientId);
      } 
    });
  });
});
// Save
$(document).ready(function() {
  $("#saveRecord").submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');
    var id = form.find('[name="patientId"]').val();

    $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(),
      success: function(response) {
        if (response.status == 200) {
          Swal.fire({
            title: response['success'],
            icon: 'success',
            confirmButtonText: 'proceed',
          }).then((response2) => {
            if (response2.isConfirmed) {
              console.log(response.newId);
              window.location.href = "/dental-treatment-record?id=" + encodeURIComponent(response.newId);
            }
          });
          console.log(response);
        }
        else if (response.status == 500) {
          Swal.fire({
            title: response['error'],
            icon: 'error',
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
  });
});

$(document).ready(function() {
  var periodontal = "{{$details->periodontal ?? '' }}";
  var occlusion = "{{$details->occlusion ?? ''}}";
  var appliances = "{{$details->appliances ?? ''}}";
  var tmd = "{{$details->tmd ?? ''}}"; 

  $("input:checkbox").each(function() {
    if (periodontal.includes($(this).val())) {
      $(this).prop("checked", true);
    }
  });
  $("input:checkbox").each(function() {
    if (occlusion.includes($(this).val())) {
      $(this).prop("checked", true);
    }
  });
  $("input:checkbox").each(function() {
    if (appliances.includes($(this).val())) {
      $(this).prop("checked", true);
    }
  });
  $("input:checkbox").each(function() {
    if (tmd.includes($(this).val())) {
      $(this).prop("checked", true);
    }
  });
});
// DATE
var today = new Date();
var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
$('.date').val(formattedDate);

// Input others appliances
const othersAppCheckbox = document.getElementById("othersApp");
const othersAppInput = document.querySelector('input[name="othersApp"]');                
                        
othersAppCheckbox.addEventListener("change", function() {
  if (this.checked) {
    othersAppInput.disabled = false;
  } else {
    othersAppInput.disabled = true;
    othersAppInput.value = ''; 
  }
});
</script>
@endsection