@php
use App\Http\Controllers\AESCipher;
@endphp  
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Treatment Record')
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
    color:rgb(58, 57, 57);
    outline: 0;
        border-width: 0;
        border-color: rgb(58, 57, 57);
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
  input[type="checkbox"] {
    width: 18px;
    height: 18px;
  }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
  }
  .textbox {
      transform: scale(1);
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
  border-left: 2px solid rgb(58, 57, 57);
  height: 230px;
  position: absolute;
  left: 50%;
  margin-left: -3px;
  top: 0;
 }
 .blur {
        filter: blur(1px);
    }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row ">
    <div class="" style="width: 17.2%">
      <div class="card">
        <div class="card-body" style="background: rgb(110, 155, 222);color:white">
          <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bolder;color:white">Legend:</label>
          <br>
            <div class=" form-group" >
                <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold;color:white">Condition</label><br>
                <label for="cancer" style="text-transform: capitalize;font-size:12px;color:white">D- Decayed (caries indicated for filing)</label><br>                
                <label for="heart" style="text-transform: capitalize;font-size:12px;color:white">M- Missing</label><br>    
                <label for="hypertension" style="text-transform: capitalize;font-size:12px;color:white">F- Filled</label><br>                      
                <label for="thyroid" style="text-transform: capitalize;font-size:12px;color:white">I- Caries indicated for Extration</label><br>                       
                <label for="tuberculosis" style="text-transform: capitalize;font-size:12px;color:white">RF- Root Fragment</label><br>                  
                <label for="thyroid" style="text-transform: capitalize;font-size:12px;color:white">MO- Missing due to Other Causes</label><br>                      
                <label for="tuberculosis" style="text-transform: capitalize;font-size:12px;color:white">Im- Impacted Tooth</label><br>
              </div>
            <div class=" mx-auto">
              <div class="form-group">
                <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold;color:white">Restoration & Prosthetics</label><br>
                <label for="diabetes" style="text-transform: capitalize;font-size:12px;color:white">J- Jacket Crown</label><br>                        
                <label for="mental" style="text-transform: capitalize;font-size:12px;color:white">A- Amalgam Filling</label><br>                       
                <label for="asthma" style="text-transform: capitalize;font-size:12px;color:white">AB- Abutment</label><br>                       
                <label for="convulsion" style="text-transform: capitalize;font-size:12px;color:white">P- Pontic</label><br>                       
                <label for="bleeding" style="text-transform: capitalize;font-size:12px;color:white">In- inlay</label><br>                       
                <label for="bleeding" style="text-transform: capitalize;font-size:12px;color:white">Fx- Fixed Cure Composite</label><br>                       
                <label for="bleeding" style="text-transform: capitalize;font-size:12px;color:white">S- Sealant</label><br>                        
                <label for="bleeding" style="text-transform: capitalize;font-size:12px;color:white">Rm- Removable Denture</label><br>
              </div>
            </div>
            <div class=" mx-auto">
              <div class="form-group">
                <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold;color:white">Surgery</label><br>
                <label for="vehiceyele1" style="text-transform: capitalize;font-size:12px;color:white">X- Extraction due to Causes</label><br>
                <label for="skin" style="text-transform: capitalize;font-size:12px;color:white">XO- Extraction due to Other Causes</label><br>
                <br>
                <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold;color:white">Others</label><br>
                <label for="gastrointestinal" style="text-transform: capitalize;font-size:12px;color:white">✓- Present Teeth</label><br>
                <label for="vehicle2" style="text-transform: capitalize;font-size:12px;color:white">Cm- Congenitally Missing</label><br>
                <label for="vehicle2" style="text-transform: capitalize;font-size:12px;color:white">Sp- Supernumerary</label><br>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="" style="width: 45%;margin-left:15px">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            {{-- <div class="card-header" style="font-size:20px;font-weight:400;font-weight: bold;background: rgb(110, 155, 222);color:white;height:50px;display:flex;align-items:center;">
                  Name:
                  <input type="text" class="col-sm-7  border-0 fullname input" style="background: rgb(110, 155, 222);color:white;" name="firstname"  id="fullname" style="" value="{{$data->firstname}} {{$data->middlename}} {{$data->lastname}}" readonly>
            </div> --}}
            <div class="card-header" style="height:50px"> 
              <h5 style="text-align:center;font-weight:bold">INTRAORAL EXAMINATION</h5>
            </div>
            <br>
            <div class="card-content">
                <div class="card-body">
                  <table class="" style="margin:auto;text-align:center;font-size:13px">
                    <thead class="head">
                      <tr>
                        <td colspan="3" style="border:none">Status</td>
                        <?php for ($i = 0; $i < 10; $i++) { ?>
                            <td class="border">
                                <input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black;font-size:16px" name="dental_issues[]" toothId="<?php echo 55 - $i; ?>" value="<?php echo isset($issueDetails[$i]) ? $issueDetails[$i] : ''; ?>" readonly>
                            </td>
                        <?php } ?>
                        <td colspan="3" style="border:none"></td>
                    </tr>
                    <tr>
                      <td colspan="3"  style="border:none;font-weight:bold;"> Right</td>
                      <?php for ($i = 55; $i >= 51; $i--) { ?>
                          <td class="border"  style="font-weight:700;"><?php echo $i; ?></td>
                      <?php } ?>
                      <?php for ($i = 61; $i <= 65; $i++) { ?>
                          <td class="border"  style="font-weight:700;"><?php echo $i; ?></td>
                      <?php } ?>
                      <td colspan="3" style="border:none;font-weight:bold;"> Left</td>
                    </tr>
                        <tr>
                          <td colspan="3" style="border:none">Temporary Teeth</td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td colspan="3" style="border:none"></td>
                      </tr>
                      <tr>
                        <?php 
                            $toothIds = ["18U", "17U", "16U", "15U", "14U", "13U", "12U", "11U", "21U", "22U", "23U", "24U", "25U", "26U", "27U", "28U"];
                            for ($i = 10; $i <= 25; $i++) {
                                echo '<td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black;font-size:16px" toothId="' . $toothIds[$i-10] . '" name="dental_issues[]" value="' . (isset($issueDetails[$i]) ? $issueDetails[$i] : '') . '" readonly></td>';
                            }
                        ?>
                    </tr>
                      <tr>
                          <?php 
                              $toothIds = ["18L", "17L", "16L", "15L", "14L", "13L", "12L", "11L", "22L", "23L", "24L", "25L", "26L", "27L", "28L", "28L"];
                              for ($i = 26; $i <= 41; $i++) {
                                  echo '<td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black;font-size:16px" toothId="' . $toothIds[$i-26] . '" name="dental_issues[]" value="' . (isset($issueDetails[$i]) ? $issueDetails[$i] : '') . '" readonly></td>';
                              }
                          ?>
                      </tr>
                      <tr>
                        <?php for ($i = 18; $i >= 11; $i--) { ?>
                            <td class="border" style="font-weight:700;"><?php echo $i; ?></td>
                        <?php } ?>
                        <?php for ($i = 21; $i <= 28; $i++) { ?>
                            <td class="border" style="font-weight:700;"><?php echo $i; ?></td>
                        <?php } ?>
                      </tr>
                        <tr>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                        </tr>
                        <tr>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                          <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                        </tr>
                        <tr>
                          <?php for ($i = 48; $i >= 41; $i--) { ?>
                              <td class="border" style="font-weight:700;"><?php echo $i; ?></td>
                          <?php } ?>
                          <?php for ($i = 31; $i <= 38; $i++) { ?>
                              <td class="border" style="font-weight:700;"><?php echo $i; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <?php
                          $toothIds = ["47L", "46L", "45L", "44L", "43L", "42L", "41L", "31L", "32L", "33L", "34L", "35L", "36L", "37L", "38L", "48U"];
                          for ($i = 42; $i <= 57; $i++) {
                              echo '<td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black;font-size:16px" toothId="' . $toothIds[$i-42] . '" name="dental_issues[]" value="' . (isset($issueDetails[$i]) ? $issueDetails[$i] : '') . '" readonly></td>';
                          }
                          ?>
                          </tr>
                          <tr>
                            <?php
                            $toothIds = ["47U", "46U", "45U", "44U", "43U", "42U", "41U", "31U", "32U", "33U", "34U", "35U", "36U", "37U", "38U", "85U"];
                            for ($i = 58; $i <= 73; $i++) {
                                echo '<td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black;font-size:16px" toothId="' . $toothIds[$i-58] . '" name="dental_issues[]" value="' . (isset($issueDetails[$i]) ? $issueDetails[$i] : '') . '" readonly></td>';
                            }
                            ?>
                            </tr>
                          <tr>
                            <td colspan="3" style="border:none">Temporary Teeth</td>
                            <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            <td colspan="3" style="border:none"></td>
                        </tr>
                        <tr>
                          <td colspan="3" style="border:none;font-weight:700;">Right</td>
                          <?php for ($i = 85; $i >= 81; $i--) { ?>
                              <td class="border" style="font-weight:700;"><?php echo $i; ?></td>
                          <?php } ?>
                          <?php for ($i = 71; $i <= 75; $i++) { ?>
                              <td class="border" style="font-weight:700;"><?php echo $i; ?></td>
                          <?php } ?>
                          <td colspan="3" style="border:none;font-weight:bold;">Left</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="border:none">Status</td>
                          <?php for ($i = 74; $i < 84; $i++) { ?>
                              <td class="border">
                                  <input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black;font-size:16px" name="dental_issues[]" toothId="<?php echo 55 - $i; ?>" value="<?php echo isset($issueDetails[$i]) ? $issueDetails[$i] : ''; ?>" readonly>
                              </td>
                          <?php } ?>
                          <td colspan="3" style="border:none"></td>
                      </tr>
                    </thead>
                </table>
                <hr>
                
                {{-- <button type="button" class="btn btn-primary btn-sm" id="toggleButton">Click Here!</button> --}}
                
              <div class="row col-md-12">
                <div class="form-group ">
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold">Periodontal Screening:</label><br>
                  <input type="checkbox" id="Gingivits " name="periodontal[]" value="Gingivits" disabled >
                  <label for="cancer" style="text-transform: capitalize;font-size:12px">Gingivits</label><br>
                  <input type="checkbox" id="vehicle1" name="periodontal[]" value="Early Periodontitis" disabled>
                  <label for="heart" style="text-transform: capitalize;font-size:12px">Early Periodontitis</label><br>
                  <input type="checkbox" id="vehicle1" name="vehicle1" value="Moderate Periodontitis" disabled>
                  <label for="hypertension" style="text-transform: capitalize;font-size:12px">Moderate Periodontitis</label><br>
                  <input type="checkbox" id="vehicle1" name="periodontal[]" value="Advance Periodontitis" disabled>
                  <label for="thyroid" style="text-transform: capitalize;font-size:12px">Advance Periodontitis</label><br>
                </div>
                <div class=" mx-auto">
                  <div class="form-group">
                    <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold">Occlusion:</label><br>
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Class Molar" disabled>
                    <label for="diabetes" style="text-transform: capitalize;font-size:12px">Class(Molar)</label><br>
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Overjet" disabled>
                    <label for="mental" style="text-transform: capitalize;font-size:12px">Overjet</label><br>
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Overbite" disabled>
                    <label for="asthma" style="text-transform: capitalize;font-size:12px">Overbite</label><br>     
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Midline Deviation" disabled>                  
                    <label for="convulsion" style="text-transform: capitalize;font-size:12px">Midline Deviation</label><br>  
                    <input type="checkbox" id="vehicle1" name="occlusion[]" value="Crossbite" disabled> 
                    <label for="bleeding" style="text-transform: capitalize;font-size:12px">Crossbite</label><br>
                  </div>
                </div>
                <div class="form-group">
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold">Appliances:</label><br>
                  <input type="checkbox" id="vehicle1" name="appliances[]" value="Orthodontic" disabled>
                  <label for="vehiceyele1" style="text-transform: capitalize;font-size:12px">Orthodontic</label><br>
                  <input type="checkbox" id="vehicle1" name="appliances[]" value="Stayplate" disabled>
                  <label for="skin" style="text-transform: capitalize;font-size:12px">Stayplate</label><br>
                  <input type="checkbox" id="others" name="appliances[]" value="Others" disabled>
                  <label for="others" style="text-transform: capitalize; font-size: 12px px">Others</label><br>
                  <input class="form-control othersApp" type="text" id="othersApp" name="othersApp" value="{{$data->othersApp}}" disabled>                  
                </div>
                <div class="mx-auto">
                  <div class="form-group">
                  <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bold">TMD:</label><br>
                  <input type="checkbox" id="vehicle1" name="tmd[]" value="Clenching" disabled>
                    <label for="diabetes" style="text-transform: capitalize;font-size:12px">Clenching</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Clicking" disabled>
                    <label for="mental" style="text-transform: capitalize;font-size:12px">Clicking</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Trismus" disabled>
                    <label for="asthma" style="text-transform: capitalize;font-size:12px">Trismus</label><br>
                    <input type="checkbox" id="vehicle1" name="tmd[]" value="Muscle Spasm" disabled> 
                    <label for="convulsion" style="text-transform: capitalize;font-size:12px">Muscle Spasm</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="" style="width: 35.9%;margin-left:15px">
    <div class="card">
      {{-- <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
        {{-- style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;" --}}
      <div class="card-header" style="font-size:18px;font-weight:400;font-weight: bold;background: rgb(110, 155, 222);color:white;height:50px;display:flex;align-items:center;">
        <i class="fa fa-id-card-o" style="font-size:30px"></i>
        <input type="text" class="col-sm-7  border-0 fullname input" style="background: rgb(110, 155, 222);color:white;" name="firstname"  id="fullname" style="" value="{{$data->firstname}} {{$data->middlename}} {{$data->lastname}}" readonly>
      </div>
      <form action="/saveRecord" method="POST" id="saveRecord"> 
      @csrf
      <input type="hidden" class="col-sm-7  border-0 fullname input"  name="stat"  id="stat" value="Created">
      <input type="hidden" class="col-sm-7  border-0 fullname input"  name="id"  id="id"  value="{{$data->id}}">
      <input type="hidden" class="col-sm-7  border-0 fullname input"  name="role"  id="role"  value="{{$data->role}}">
      <input type="hidden" class="col-sm-7  border-0 fullname input"  name="gender"  id="gender"  value="{{$data->gender}}">
      <input type="hidden" class="col-sm-7  border-0 fullname input"  name="age"  id="gender"  value="{{$age ?? ''}}">
        <div class="card-body" >
          <h6 style="text-align:center">TREATMENT RECORD</h6>
          <div style="text-align: right">
            <div style="font-weight: 400; font-size: 16px;">
              <label for="example-month-input" class="col-2 ">date<span class="text-danger">*</span></label>
              <input class="form-control col-sm-3 date float-right @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" value="" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date" name="date">
          </div>
        </div>
        <div class="form-outline ">
            <label class="form-label" for="textAreaExample" style="font-size: 15px">Diagnosis:<span class="text-danger">*</span></label>
            <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" value="{{ old('diagnosis') }}" required autocomplete="diagnosis" id="diagnosis" rows="4"></textarea>
        </div>
        <div class="form-outline">
            <label class="form-label" for="textAreaExample" style="font-size: 15px">Treatment:</label>
            <textarea class="form-control" name="treatment" value=""  id="treatment" rows="4" autocomplete="off"></textarea>
        </div>
        <hr>
        <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bolder">Remarks:</label>
          <div class="form-check" style="width: 50%">
            <input type="checkbox" id="" name="remarks[]" value="Consultation">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Dental Check-up/ Consultation</label>
          </div>
          <div class="form-check" style="width: 50%">
            <input type="checkbox" id="" name="remarks[]" value="Oral Restoration">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Cavity Filling/ Oral Restoration</label>
          </div>
          <div class="form-check" style="width: 50%">
            <input type="checkbox" id="" name="remarks[]" value="Oral Prophylaxis">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Oral Prophylaxis</label>
          </div>
          <div class="form-check">
            <input type="checkbox" id="" name="remarks[]" value="Tooth Extraction">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Tooth Extraction</label>
          </div>
          <div class="form-check">
            <input type="checkbox" id="" name="remarks[]" value="OTC Medicine">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">OTC Medicine</label>
          </div>
           <div class="form-check">
            <input type="checkbox" id="" name="remarks[]" value="Dental Certificate">
            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Dental Certificate</label>
          </div>
        </div>
        <div id="spinner-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.2); z-index: 9999;">
          <div class="d-flex justify-content-center align-items-center h-100">
              <div class="spinner-border spinner-border-lg text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
        </div>
        <button type="button" id="button" class="btn btn-default btn-custom float-right button">Cancel</button>
        <button type="submit" class="btn btn-primary btn-custom float-right" id="checkBtn">Save</button>
      </form> 
      <br>
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

//date
// var today = new Date().toISOString().split('T')[0];
// document.getElementById('date').setAttribute('max', today);

//For Cancelling
document.getElementById('button').addEventListener('click', function(event) {
    var diagnosis = document.getElementById('diagnosis').value;

    if (treatment.trim() === '' || diagnosis.trim() === '') {
      event.preventDefault(); 

      Swal.fire({
        title: 'Error!',
        text: 'Treatment field are required!',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }else{
      window.history.back();
    }
});

//Datatables
var today = new Date();
var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

$('.date').val(formattedDate);

$(document).ready(function() {
  $('.datatables').DataTable({
   'aLengthMenu' :[[10,20,50,100,-1],[10,20,50,100,'All']],

   "order": [[ 4, "asc" ], [ 0, "desc" ]], 
   "columnDefs": [
        { "orderable": false, "targets": 5 } 
    ]
  })
});  

//For the checkbox 
$(document).ready(function() {
    var periodontal = "{{$data->periodontal}}";
    var occlusion = "{{$data->occlusion}}";
    var appliances = "{{$data->appliances}}";
    var tmd = "{{$data->tmd}}";
    console.log(remarks);

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

//For Save
$("#saveRecord").submit(function (e) {
  e.preventDefault();
  var form = $(this);
  var actionUrl = form.attr('action')

  $("#saveBtn").prop("disabled", true)
  $("#spinner-overlay").show();
    $(".blur").addClass("blur");

  if (!$("input[name='remarks[]']:checked").length) {
    swal.fire({
      title: "Error",
      text: "Please select at least one Remark.",
      icon: "error",
      button: "OK",
    });

    $("#spinner-overlay").hide();
    $(".blur").removeClass("blur");
    $("#saveBtn").prop("disabled", false);

  } else {
    $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(),
      success: function (response) {

        $("#spinner-overlay").hide();
        $(".blur").removeClass("blur");

        console.log(response); 
        if (response.status == 200) {
        Swal.fire({
          title: response['success'],
          icon: 'success', 
          confirmButtonText: 'Okay',
        }).then((response1) => {
          
          $("#saveBtn").prop("disabled", false);

          if (response1.isConfirmed) {
            window.location.href = "/treatment-record-status?id=" + encodeURIComponent(response.newId);
          }
        });
        console.log(response);
      } else if (response.Error == 1){
          Swal.fire({
          icon: "error",
          title: response.Message,
          
         }).then((response2) => {
          $("#saveBtn").prop("disabled", false);

        });
        }
      }
    });
  }
});

//Back button in View
$(document).ready(function(){
    $("#button").click(function(){
      window.history.back();
  })
 });

//others
const othersCheckbox = document.getElementById("others");
const othersInput = document.getElementById("othersApp");
const othersApp = "{{$data->othersApp}}"; 
if (othersApp === othersCheckbox.value) { 
  othersCheckbox.checked = true;
  othersInput.disabled = false;
  othersInput.value = othersApp; 
}
othersCheckbox.addEventListener("change", function() {
  if (this.checked) {
    othersInput.disabled = false;
    othersInput.value = othersApp; 
  } else {
    othersInput.disabled = true;
    othersInput.value = ''; 
  }
});
</script>
@endsection