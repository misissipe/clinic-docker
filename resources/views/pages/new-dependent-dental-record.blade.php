@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Dental Chart')

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
    background: url('path_to_custom_arrow_image.png') no-repeat; /* Replace with your custom arrow image */
    background-position: right center;
    background-size: auto;
    padding-right: 20px; /* Adjust padding to make space for the custom arrow */
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
      @if (isset($record))
      @if ($dentalchart === null)
      <div class="" style="width: 100%" >
        <div class="card border"  style="margin-bottom: 20px;">
          <div class="card-body" style="" >
            <div class="col-sm-12">
              <div class="row col-12" style="font-size:16px;font-weight:400;font-weight: bold;">
                Employee ID:
                <input type="text" class="col-sm-1 cert input" name="employeeId"  id="patientId" style="" value="{{$record->EmployeeId}}" readonly>
              </div> 
              <div class="row col-12" style="font-size:16px;font-weight:400;font-weight: bold;">
                Name:
                <input type="text" class="col-sm-2 cert input" name="firstname"  id="firstname" style="" value="{{$record->FirstName}}"  readonly>&emsp;
                <input type="text" class="col-sm-2 cert input" name="middlename" id="middlename" style="" value="{{$record->MiddleName}}"  readonly>&emsp;
                <input type="text" class="col-sm-2 cert input" name="lastname"   id="lastname" style="" value="{{$record->LastName}}"  readonly>&emsp;
                Age:
                <input type="text" class="col-sm-1 cert input" name="age"  id="age" style="" value="{{$age}}"  readonly>
                Gender:
                <input type="text" class="col-sm-1 cert input" name="gender"  id="gender" style="" value="{{$record->Gender}}" readonly>
                Date:
                <input class=" col-sm-2 cert float-right date @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" value="" id="date" name="date">
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
                <label for="cancer" style="text-transform: capitalize; font-size: 14px;color:white"><b>D</b>- Decayed (caries indicated for filing)</label><br>
                <label for="heart" style="text-transform: capitalize;font-size:14px;color:white"><b>M</b>- Missing</label><br>    
                <label for="hypertension" style="text-transform: capitalize;font-size:14px;color:white"><b>F</b>- Filled</label><br>                      
                <label for="thyroid" style="text-transform: capitalize;font-size:14px;color:white"><b>I</b>- Caries indicated for Extration</label><br>                       
                <label for="tuberculosis" style="text-transform: capitalize;font-size:14px;color:white"><b>RF</b>- Root Fragment</label><br>                  
                <label for="thyroid" style="text-transform: capitalize;font-size:14px;color:white"><b>MO</b>- Missing due to Other Causes</label><br>                      
                <label for="tuberculosis" style="text-transform: capitalize;font-size:14px;color:white"><b>Im</b>- Impacted Tooth</label>
              </div>
              <div class=" mx-auto">
                <div class="form-group">
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Restoration & Prosthetics</label><br>
                  <label for="diabetes" style="text-transform: capitalize;font-size:14px;color:white"><b>J</b>- Jacket Crown</label><br>                        
                  <label for="mental" style="text-transform: capitalize;font-size:14px;color:white"><b>A</b>- Amalgam Filling</label><br>                       
                  <label for="asthma" style="text-transform: capitalize;font-size:14px;color:white"><b>AB</b>- Abutment</label><br>                       
                  <label for="convulsion" style="text-transform: capitalize;font-size:14px;color:white"><b>P</b>- Pontic</label><br>                       
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>In</b>- inlay</label><br>                       
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>Fx</b>- Fixed Cure Composite</label><br>                       
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>S</b>- Sealant</label><br>                        
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>Rm</b>- Removable Denture</label>
                </div>
              </div>
              <div class=" mx-auto">
                <div class="form-group">
                  
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Surgery</label><br>
                  <label for="vehiceyele1" style="text-transform: capitalize;font-size:14px;color:white"><b>X</b>- Extraction due to Causes</label><br>
                  <label for="skin" style="text-transform: capitalize;font-size:14px;color:white"><b>XO</b>- Extraction due to Other Causes</label><br>
                  <br>
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Others</label><br>
                  <label for="gastrointestinal" style="text-transform: capitalize;font-size:14px;color:white"><b>✓</b>- Present Teeth</label><br>
                  <label for="vehicle2" style="text-transform: capitalize;font-size:14px;color:white"><b>Cm</b>- Congenitally Missing</label><br>
                  <label for="vehicle2" style="text-transform: capitalize;font-size:14px;color:white"><b>Sp</b>- Supernumerary</label>
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
              <form action="/addDependent" method="POST" id="saveRecord"> 
              @csrf
                <input type="hidden" class=" col-sm-1 input " name="role"  id="role" style="" value="Student" >
                <input type="hidden" class=" col-sm-2 border-0 id" name="patientId"  id="id" style="font-weight: bold;" value={{$record->id}} readonly>
                {{-- <input type="hidden" class=" col-sm-2 border-0 id" name="appointmentId"  id="id" style="font-weight: bold;" value={{$appointmentId}} readonly> --}}
                <input type="hidden" class=" col-sm-2 border-0 id" name="status"  id="id" style="font-weight: bold;" value="Created" readonly>
                <input type="hidden" class=" cert col-sm-2 border-0 fullname input" name="firstname"  id="fullname" style="" value="{{$record->FirstName}} " readonly>
                <input type="hidden" class="  border-0 fullname input" name="middlename"  id="fullname" style="" value="{{$record->MiddleName}}" readonly>
                <input type="hidden" class="  border-0 fullname input" name="lastname"  id="fullname" style="width:34%" value="{{$record->LastName}}" readonly>
                <input type="hidden" class=" col-sm-3  age input" name="age"  id="age" style="font-weight: bold;font-size:16px;" value={{$age}} readonly>
                <input type="hidden" class=" col-sm-1  age input" name="gender"  id="age" style="font-weight: bold;font-size:16px;" value={{$record->Gender}} readonly>
                <input type="hidden" class=" col-sm-1  BirthDate input" name="BirthDate"  id="BirthDate" style="font-weight: bold;font-size:16px;" value={{$record->BirthDate}} readonly>
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
                                      <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="{{ 55 - $i }}" style="font-size: 14px;font-weight:bold;">
                                          <option disable selected></option>
                                          <?php
                                          $legends = array("D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In","Fx","S","Rm","X","XO","✓","Cm","Sp");
                                          foreach ($legends as $legend) {
                                              echo "<option value=\"$legend\">$legend</option>";
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
                                <option disabled selected></option>
                                @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                                  <option value="{{ $legend }}">{{ $legend }}</option>
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
                                <option disabled selected></option>
                                @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                                  <option value="{{ $legend }}">{{ $legend }}</option>
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
                                <option disabled selected></option>
                                @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                                  <option value="{{ $legend }}">{{ $legend }}</option>
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
                                <option disabled selected></option>
                                @foreach (["D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In", "Fx", "S", "Rm", "X", "XO", "✓", "Cm", "Sp"] as $legend)
                                  <option value="{{ $legend }}">{{ $legend }}</option>
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
                                  @if(isset($issueDetails[$i]))
                                      <input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="{{ 55 - $i }}" value="{{ $issueDetails[$i] }}" readonly>
                                  @else
                                      <select class="form-select border-0" name="dental_issues[]" aria-label="Default select example" toothId="{{ 55 - $i }}" style="font-size: 14px;font-weight:bold;">
                                          <option disable selected></option>
                                          <?php
                                          $legends = array("D", "M", "F", "I", "RF", "MO", "Im", "J", "A", "AB", "P", "In","Fx","S","Rm","X","XO","✓","Cm","Sp");
                                          foreach ($legends as $legend) {
                                              echo "<option value=\"$legend\">$legend</option>";
                                          }
                                          ?>
                                      </select>
                                  @endif
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
          </form>{{-- end form--}}
        </div>
      </div>
      @elseif($dentalchart !== null) 
      <div class="" style="width: 100%" >
        <div class="card border"  style="margin-bottom: 20px;">

          <div class="card-body" style="" >
            <div class="col-sm-12">
              <div class="row col-12" style="font-size:16px;font-weight:400;font-weight: bold;">
                Employee ID:
                <input type="text" class="col-sm-1 cert input" name="employeeId"  id="patientId" style="" value="{{$record->EmployeeId}}" readonly>
              </div> 
              <div class="row col-12" style="font-size:16px;font-weight:400;font-weight: bold;">
                Name:
                <input type="text" class="col-sm-2 cert input" name="firstname"  id="firstname" style="" value="{{$record->FirstName}}"  readonly>&emsp;
                <input type="text" class="col-sm-2 cert input" name="middlename" id="middlename" style="" value="{{$record->MiddleName}}"  readonly>&emsp;
                <input type="text" class="col-sm-2 cert input" name="lastname"   id="lastname" style="" value="{{$record->LastName}}"  readonly>&emsp;
                Age:
                <input type="text" class="col-sm-1 cert input" name="age"  id="age" style="" value="{{$age}}"  readonly>
                Gender:
                <input type="text" class="col-sm-1 cert input" name="gender"  id="gender" style="" value="{{$record->Gender}}" readonly>
                Date:
                <input class=" col-sm-2 cert float-right date @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" value="" id="date" name="date">
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
                <label for="cancer" style="text-transform: capitalize; font-size: 14px;color:white"><b>D</b>- Decayed (caries indicated for filing)</label><br>
                <label for="heart" style="text-transform: capitalize;font-size:14px;color:white"><b>M</b>- Missing</label><br>    
                <label for="hypertension" style="text-transform: capitalize;font-size:14px;color:white"><b>F</b>- Filled</label><br>                      
                <label for="thyroid" style="text-transform: capitalize;font-size:14px;color:white"><b>I</b>- Caries indicated for Extration</label><br>                       
                <label for="tuberculosis" style="text-transform: capitalize;font-size:14px;color:white"><b>RF</b>- Root Fragment</label><br>                  
                <label for="thyroid" style="text-transform: capitalize;font-size:14px;color:white"><b>MO</b>- Missing due to Other Causes</label><br>                      
                <label for="tuberculosis" style="text-transform: capitalize;font-size:14px;color:white"><b>Im</b>- Impacted Tooth</label>
              </div>
              <div class=" mx-auto">
                <div class="form-group">
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Restoration & Prosthetics</label><br>
                  <label for="diabetes" style="text-transform: capitalize;font-size:14px;color:white"><b>J</b>- Jacket Crown</label><br>                        
                  <label for="mental" style="text-transform: capitalize;font-size:14px;color:white"><b>A</b>- Amalgam Filling</label><br>                       
                  <label for="asthma" style="text-transform: capitalize;font-size:14px;color:white"><b>AB</b>- Abutment</label><br>                       
                  <label for="convulsion" style="text-transform: capitalize;font-size:14px;color:white"><b>P</b>- Pontic</label><br>                       
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>In</b>- inlay</label><br>                       
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>Fx</b>- Fixed Cure Composite</label><br>                       
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>S</b>- Sealant</label><br>                        
                  <label for="bleeding" style="text-transform: capitalize;font-size:14px;color:white"><b>Rm</b>- Removable Denture</label>
                </div>
              </div>
              <div class=" mx-auto">
                <div class="form-group">
                  
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Surgery</label><br>
                  <label for="vehiceyele1" style="text-transform: capitalize;font-size:14px;color:white"><b>X</b>- Extraction due to Causes</label><br>
                  <label for="skin" style="text-transform: capitalize;font-size:14px;color:white"><b>XO</b>- Extraction due to Other Causes</label><br>
                  <br>
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold;color:white">Others</label><br>
                  <label for="gastrointestinal" style="text-transform: capitalize;font-size:14px;color:white"><b>✓</b>- Present Teeth</label><br>
                  <label for="vehicle2" style="text-transform: capitalize;font-size:14px;color:white"><b>Cm</b>- Congenitally Missing</label><br>
                  <label for="vehicle2" style="text-transform: capitalize;font-size:14px;color:white"><b>Sp</b>- Supernumerary</label>
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
        <form action="/addDependent" method="POST" id="saveRecord"> 
        @csrf
                <input type="hidden" class=" col-sm-1 input " name="role"  id="role" style="" value="Student" >
                <input type="hidden" class=" col-sm-2 border-0 id" name="patientId"  id="id" style="font-weight: bold;" value={{$record->id}} readonly>
                {{-- <input type="hidden" class=" col-sm-2 border-0 id" name="appointmentId"  id="id" style="font-weight: bold;" value={{$appointmentId}} readonly> --}}
                <input type="hidden" class=" col-sm-2 border-0 id" name="status"  id="id" style="font-weight: bold;" value="Created" readonly>
                <input type="hidden" class=" cert col-sm-2 border-0 fullname input" name="firstname"  id="fullname" style="" value="{{$record->FirstName}} " readonly>
                <input type="hidden" class="  border-0 fullname input" name="middlename"  id="fullname" style="" value="{{$record->MiddleName}}" readonly>
                <input type="hidden" class="  border-0 fullname input" name="lastname"  id="fullname" style="width:34%" value="{{$record->LastName}}" readonly>
                <input type="hidden" class=" col-sm-1  BirthDate input" name="BirthDate"  id="BirthDate" style="font-weight: bold;font-size:16px;" value={{$record->BirthDate}} readonly>
                <h5 style="font-weight:700">INTRAORAL EXAMINATION</h5>
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
          </form>{{-- end form--}}
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
        $.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

          //For the checkbox 
        $(document).ready(function() {
          var periodontal = "{{$details->periodontal}}";
          var occlusion = "{{$details->occlusion}}";
          var appliances = "{{$details->appliances}}";
          var tmd = "{{$details->tmd}}";

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
      </script>
      
      @endif
      @else
      <div class="card-panel red lighten-3">
                           
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
    
$(document).ready(function(){
        $("#cancelBtn").click(function(){
          window.history.back();
      })
    })

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


//Save SWAL ALERT 
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
        }
      });
    
  });
});


var today = new Date();
var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

$('.date').val(formattedDate);


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