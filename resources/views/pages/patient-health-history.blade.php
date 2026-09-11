@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

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
                  <div class="table-responsive">
                    <div class="col-sm-12">
                      @if (isset($response))
                      @if ($healthHistory === null)
                      <form  action="/updateStdentRecord" method="post" id="updateForm">
                      @csrf
                      <input type="text" class=" col-sm-8 border-0 id" name="patientId" value="{{$newencryptedId}}" id="id" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                      <h5 style="text-align:center; font-weight:bold;">PLEASE CHECK THE BOX IF ONE OF THE FOLLOWING IS APPLICABLE TO YOU</h5>
                          <div class="title">
                              <h6 style="text-decoration: underline; text-align:center;font-weight: bold; font-style: italic;color:royalblue)">MEDICAL AND SOCIAL HEALTH HISTORY</h6>
                          </div>
                        {{-- Family Health History --}}
                        <div class="row" >
                          <div class="col-sm-2">
                            Family Health History</span>:
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
                              <input type="checkbox" id="diabetes" name="family_his[]" value="Diabetes Mellitus">
                              <label for="diabetes">Diabetes Mellitus</label><br>
                              <input type="checkbox" id="mental" name="family_his[]" value="Mental Disorder">
                              <label for="mental">Mental Disorder</label><br>
                              <input type="checkbox" id="asthma" name="family_his[]" value="Asthma">
                              <label for="asthma">Asthma</label><br>
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
                                <input type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                                <label for="gastrointestinal">Gastrointestinal disease</label><br>
                                <input type="checkbox" id="othersFamhis" name="family_his[]" value="Others">
                                <label for="vehicle2">Others:</label><br>
                                <input class="form-control othersFamhis" type="text" id="othersFamhis" name="othersFamhis" value="" disabled>
                            </div>
                          </div>
                          <div class="col-sm-2" style="border-left: 1px solid rgb(207, 206, 206)" >
                            <div class="form-group">
                              <div>
                                Personal Social History:
                              </div>
                                <input type="checkbox" id="smoking" name="personal_his[]" value="Smoking" >
                                <label for="smoking">Smoking</label><br>
                              <div class="form-group w-50">
                                <label for="day">sticks/day</label><br>
                                <input class="form-control" type="number" id="sticksPerDay" name="sticksPerDay" value="" disabled>
                                <label for="year">for year/s</label><br>
                                <input class="form-control" type="number" id="forYears" name="forYears" value="" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group"><br>
                              <input type="checkbox" id="drinking" name="personal_his[]" value="Drinking">
                              <label for="drinking">Drinking</label><br>
                            <div class="form-group w-50">
                              <label for="shots">shot per day</label><br>
                                <input class="form-control" type="number" id="shots" name="shotPerday" value="" disabled>
                                <label for="beer">beer per day</label><br>
                                <input class="form-control" type="number" id="beer" name="beerPerday" value="" disabled>
                            </div>
                            </div>
                          </div>
                        </div><hr>
                        {{-- Personal Health History --}}
                        <div>
                          <h6> Personal Health History: </h6>
                        </div>
                        {{-- Past Illness --}}
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="form-group">
                                <div>
                                  Past Illness<span class="text-danger">*</span>
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
                                  <input type="checkbox" id="Asthmas" name="past_illness[]" value="Asthmas">
                                  <label for="Asthma">Asthma</label><br>
                                  <input type="checkbox" id="Diabetes" name="past_illness[]" value="Diabetes">
                                  <label for="Diabetes">Diabetes</label><br>
                                  <input type="checkbox" id="EyeDisorder" name="past_illness[]" value="Eye Disorder">
                                  <label for="EyeDisorder">Eye Disorder</label><br>
                                  <input type="checkbox" id="Pneumonia" name="past_illness[]"value="Pneumonia">
                                  <label for="Pneumonia">Pneumonia</label><br>
                                  <input type="checkbox" id="Dengue" name="past_illness[]" value="Dengue">
                                  <label for="Dengue">Dengue</label><br>
                                  <input type="checkbox" id="Measles" name="past_illness[]" value="Measles">
                                  <label for="Measles">Measles</label><br>
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
                                  <input type="checkbox" id="Mumps" name="past_illness[]" value="Mumps">
                                  <label for="Mumps">Mumps</label><br>
                              </div>
                            </div>
                            {{-- Present Illness --}}
                            <div class="col-sm-2" style="border-left: 1px solid rgb(207, 206, 206)" >
                              <div class="form-group">
                                <div>
                                  Present Illness
                                </div>
                                  <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                                  <label for="ChestPain">Chest Pain</label><br>
                                  <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                                  <label for="Insomnia">Insomnia</label><br>
                                  <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                                  <label for="JointPains">Joint Pains</label><br>
                                  <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                                  <label for="Dizziness">Dizziness</label><br>    
                                  <input type="checkbox" id="othersPreIll" name="present_illness[]" value="Others">        
                                  <label for="vehicle2">Others:</label><br>
                                  <input class="form-control othersPres" type="text" id="othersPreIll" name="othersPreIll" value="" disabled>       
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
                          <input type="text" class="form-control hospitalization_details" id="hospitalization_details" name="hos_detail" value="" placeholder="" disabled><br>
                          <label for="medicine">Are you taking any medicine regularly?</label><br>
                          <input type="checkbox" id="medicine_checkbox" value="If yes, name of drug/s"name="medicine_mnt">&nbsp;If yes, name of drug/s
                          <input type="text" class="form-control medicine_details" id="medicine_details" name="med_detail" value="" placeholder="" disabled><br>
                          <label for="allergies">Are you allergic to any food or medicine?</label><br>
                          <input type="checkbox" id="allergies_checkbox" value="If yes, specify" name="allergies">&nbsp;If yes, specify
                          <input type="text" class="form-control allergies_details" id="allergies_details" name="al_detail" value="" placeholder="" disabled><br>
                                <hr> 
                             {{-- Immunization History --}}
                            <div>
                            Immunization History<span class="text-danger">*</span>:
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
                                  <input type="checkbox" id="othersImmu" name="immunization_his[]" value="Others">        
                                  <label for="vehicle2">Others:</label><br>
                                  <input class="form-control othersImmu" type="text" id="othersImmu" name="othersImmu" value="" disabled>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="form-group">
                                  <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="Mumps Immunization">
                                  <label for="MumpsImmu">Mumps</label><br>
                                  <input type="checkbox" id="MeaslesImmu" name="immunization_his[]" value="Measles">
                                  <label for="MeaslesImmu">Measles</label><br>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="form-group">
                                  <input type="checkbox" id="Typhoid" name="immunization_his[]" value="Typhoid">
                                  <label for="Typhoid">Typhoid</label><br>
                                  <input type="checkbox" id="German" name="immunization_his[]" value="German Measles">
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
                              <button type="button" id="button" class="btn btn-default btn-custom float-right">Cancel</button>
                              <button type="submit" class="btn btn-primary btn-custom float-right" id="checkBtn">Save</button>
                          </div><!-- /.col-sm-offset-3 col-sm-9 -->   
                      </form>
                      <script>
                        //Family History
                          const othersFamhisCheckbox = document.getElementById("othersFamhis");
                          const othersFamhisInput = document.querySelector('input[name="othersFamhis"]');
                         
                        
                          othersFamhisCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              othersFamhisInput.disabled = false;
                            } else {
                              othersFamhisInput.disabled = true;
                              othersFamhisInput.value = ''; 
                            }
                          });

                        //Present Illness
                          const othersPreIllCheckbox = document.getElementById("othersPreIll");
                          const othersPreIllInput = document.querySelector('input[name="othersPreIll"]');
                         
                          othersPreIllCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              othersPreIllInput.disabled = false;
                            } else {
                              othersPreIllInput.disabled = true;
                              othersPreIllInput.value = '';
                            }
                          });

                        //Immunization History
                          const othersImmuCheckbox = document.getElementById("othersImmu");
                            const othersImmuInput = document.querySelector('input[name="othersImmu"]');
                          
                          othersImmuCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              othersImmuInput.disabled = false;
                            } else {
                              othersImmuInput.disabled = true;
                              othersImmuInput.value = '';
                            }
                          });

                        //Personal History
                          const smokingCheckbox = document.getElementById("smoking");
                          const sticksPerDayInput = document.getElementById("sticksPerDay");
                          const forYearsInput = document.getElementById("forYears");
                          


                          smokingCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              sticksPerDayInput.disabled = false;
                              forYearsInput.disabled = false;
                            } else {
                              sticksPerDayInput.disabled = true;
                              forYearsInput.disabled = true;
                              forYearsInput.value = '';
                              sticksPerDayInput.value = '';
                            }
                          });

                          const drinkingCheckbox = document.getElementById("drinking");
                          const shotPerdayInput = document.querySelector('input[name="shotPerday"]');
                          const beerPerdayInput = document.querySelector('input[name="beerPerday"]');


                          drinkingCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              shotPerdayInput.disabled = false;
                              beerPerdayInput.disabled = false;
                            } else {
                              shotPerdayInput.disabled = true;
                              beerPerdayInput.disabled = true;
                              shotPerdayInput.value = '';
                              beerPerdayInput.value = '';
                            }
                          });
                          

                        //hospitatlization
                          const hospitalizationCheckbox = document.getElementById('hospitalization_checkbox');
                          const hospitalizationDetails = document.getElementById('hospitalization_details');

                          hospitalizationCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              hospitalizationDetails.disabled = false;
                            } else {
                              hospitalizationDetails.disabled = true;

                              hospitalizationDetails.value = '';
                            }
                          });
                        //maintenance
                        
                          const medicineCheckbox = document.getElementById('medicine_checkbox');
                          const medicineDetails = document.getElementById('medicine_details');

                          medicineCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              medicineDetails.disabled = false;
                            } else {
                              medicineDetails.disabled = true;

                              medicineDetails.value = '';
                            }
                          });

                        //allergies
                       
                          const allergiesCheckbox = document.getElementById('allergies_checkbox');
                          const allergiesDetails = document.getElementById('allergies_details');

                          allergiesCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                              allergiesDetails.disabled = false;
                            } else {
                              allergiesDetails.disabled = true;

                              allergiesDetails.value = '';
                            }
                          });
                      </script>
                      @elseif($healthHistory !== null) 
                      <form  action="/updateStdentRecord" method="post" id="updateForm">
                        @csrf
                        <input type="text" class=" col-sm-8 border-0 id" name="patientId" value="{{$newencryptedId}}" id="id" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
                        <h5 style="text-align:center; font-weight:bold;">PLEASE CHECK THE BOX IF ONE OF THE FOLLOWING IS APPLICABLE TO YOU</h5>
                            <div class="title">
                                <h6 style="text-decoration: underline; text-align:center;font-weight: bold; font-style: italic;color:royalblue)">MEDICAL AND SOCIAL HEALTH HISTORY</h6>
                            </div>
                          {{-- Family Health History --}}
                          <div class="row" >
                            <div class="col-sm-2">
                              Family Health History</span>:
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
                                <input type="checkbox" id="diabetes" name="family_his[]" value="Diabetes Mellitus">
                                <label for="diabetes">Diabetes Mellitus</label><br>
                                <input type="checkbox" id="mental" name="family_his[]" value="Mental Disorder">
                                <label for="mental">Mental Disorder</label><br>
                                <input type="checkbox" id="asthma" name="family_his[]" value="Asthma">
                                <label for="asthma">Asthma</label><br>
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
                                  <input type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                                  <label for="gastrointestinal">Gastrointestinal disease</label><br>
                                  <input type="checkbox" id="othersFamhis" name="family_his[]" value="Others">
                                  <label for="vehicle2">Others:</label><br>
                                  <input class="form-control othersFamhis" type="text" id="othersFamhis" name="othersFamhis" value="{{$response->othersFamhis}}" disabled>
                              </div>
                            </div>
                            <div class="col-sm-2" style="border-left: 1px solid rgb(207, 206, 206)" >
                              <div class="form-group">
                                <div>
                                  Personal Social History:
                                </div>
                                  <input type="checkbox" id="smoking" name="personal_his[]" value="Smoking" >
                                  <label for="smoking">Smoking</label><br>
                                <div class="form-group w-50">
                                  <label for="day">sticks/day</label><br>
                                  <input class="form-control" type="number" id="sticksPerDay" name="sticksPerDay" value="{{$response->sticksPerDay}}" disabled>
                                  <label for="year">for year/s</label><br>
                                  <input class="form-control" type="number" id="forYears" name="forYears" value="{{$response->forYears}}" disabled>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group"><br>
                                <input type="checkbox" id="drinking" name="personal_his[]" value="Drinking">
                                <label for="drinking">Drinking</label><br>
                              <div class="form-group w-50">
                                <label for="shots">shot per day</label><br>
                                  <input class="form-control" type="number" id="shots" name="shotPerday" value="{{$response->beerPerDay}}" disabled>
                                  <label for="beer">beer per day</label><br>
                                  <input class="form-control" type="number" id="beer" name="beerPerday" value="{{$response->shotPerDay}}" disabled>
                              </div>
                              </div>
                            </div>
                          </div><hr>
                          {{-- Personal Health History --}}
                          <div>
                            <h6> Personal Health History: </h6>
                          </div>
                          {{-- Past Illness --}}
                            <div class="row">
                              <div class="col-sm-2">
                                <div class="form-group">
                                  <div>
                                    Past Illness<span class="text-danger">*</span>
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
                                    <input type="checkbox" id="Asthmas" name="past_illness[]" value="Asthmas">
                                    <label for="Asthma">Asthma</label><br>
                                    <input type="checkbox" id="Diabetes" name="past_illness[]" value="Diabetes">
                                    <label for="Diabetes">Diabetes</label><br>
                                    <input type="checkbox" id="EyeDisorder" name="past_illness[]" value="Eye Disorder">
                                    <label for="EyeDisorder">Eye Disorder</label><br>
                                    <input type="checkbox" id="Pneumonia" name="past_illness[]"value="Pneumonia">
                                    <label for="Pneumonia">Pneumonia</label><br>
                                    <input type="checkbox" id="Dengue" name="past_illness[]" value="Dengue">
                                    <label for="Dengue">Dengue</label><br>
                                    <input type="checkbox" id="Measles" name="past_illness[]" value="Measles">
                                    <label for="Measles">Measles</label><br>
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
                                    <input type="checkbox" id="Mumps" name="past_illness[]" value="Mumps">
                                    <label for="Mumps">Mumps</label><br>
                                </div>
                              </div>
                              {{-- Present Illness --}}
                              <div class="col-sm-2" style="border-left: 1px solid rgb(207, 206, 206)" >
                                <div class="form-group">
                                  <div>
                                    Present Illness
                                  </div>
                                    <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                                    <label for="ChestPain">Chest Pain</label><br>
                                    <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                                    <label for="Insomnia">Insomnia</label><br>
                                    <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                                    <label for="JointPains">Joint Pains</label><br>
                                    <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                                    <label for="Dizziness">Dizziness</label><br>    
                                    <input type="checkbox" id="othersPreIll" name="present_illness[]" value="Others">        
                                    <label for="vehicle2">Others:</label><br>
                                    <input class="form-control othersPres" type="text" id="othersPreIll" name="othersPreIll" value="{{$response->othersPreIll}}" disabled>       
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
                            <input type="text" class="form-control hospitalization_details" id="hospitalization_details" name="hos_detail" value="{{$response->hos_detail}}" placeholder="" disabled><br>
                            <label for="medicine">Are you taking any medicine regularly?</label><br>
                            <input type="checkbox" id="medicine_checkbox" value="If yes, name of drug/s"name="medicine_mnt">&nbsp;If yes, name of drug/s
                            <input type="text" class="form-control medicine_details" id="medicine_details" name="med_detail" value="{{$response->med_detail}}" placeholder="" disabled><br>
                            <label for="allergies">Are you allergic to any food or medicine?</label><br>
                            <input type="checkbox" id="allergies_checkbox" value="If yes, specify" name="allergies">&nbsp;If yes, specify
                            <input type="text" class="form-control allergies_details" id="allergies_details" name="al_detail" value="{{$response->al_detail}}" placeholder="" disabled><br>
                                  <hr> 
                               {{-- Immunization History --}}
                              <div>
                              Immunization History<span class="text-danger">*</span>:
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
                                    <input type="checkbox" id="othersImmu" name="immunization_his[]" value="Others">        
                                    <label for="vehicle2">Others:</label><br>
                                    <input class="form-control othersImmu" type="text" id="othersImmu" name="othersImmu" value="{{$response->othersImmu}}" disabled>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="Mumps Immunization">
                                    <label for="MumpsImmu">Mumps</label><br>
                                    <input type="checkbox" id="MeaslesImmu" name="immunization_his[]" value="Measles">
                                    <label for="MeaslesImmu">Measles</label><br>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                    <input type="checkbox" id="Typhoid" name="immunization_his[]" value="Typhoid">
                                    <label for="Typhoid">Typhoid</label><br>
                                    <input type="checkbox" id="German" name="immunization_his[]" value="German Measles">
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
                                <button type="button" id="button" class="btn btn-default btn-custom float-right">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-custom float-right" id="checkBtn">Save</button>
                            </div><!-- /.col-sm-offset-3 col-sm-9 -->   
                        </form>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                          //Family History
                            const othersFamhisCheckbox = document.getElementById("othersFamhis");
                            const othersFamhisInput = document.querySelector('input[name="othersFamhis"]');
                            const family_his = "{{$response->family_his}}";

                            if (family_his.includes(othersFamhisCheckbox.value)) {
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
                            const othersPreIllCheckbox = document.getElementById("othersPreIll");
                            const othersPreIllInput = document.querySelector('input[name="othersPreIll"]');
                            const present_illness = "{{$response->present_illness}}";

                            if (present_illness.includes(othersPreIllCheckbox.value)) {
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
                            const othersImmuCheckbox = document.getElementById("othersImmu");
                              const othersImmuInput = document.querySelector('input[name="othersImmu"]');
                              const immunization_his = "{{$response->immunization_his}}";

                            if (immunization_his.includes(othersImmuCheckbox.value)) {
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
                            const smokingCheckbox = document.getElementById("smoking");
                            const sticksPerDayInput = document.getElementById("sticksPerDay");
                            const forYearsInput = document.getElementById("forYears");
                            const personal_his = "{{$response->personal_his}}";

                            if (personal_his.includes(smokingCheckbox.value)) {
                              smokingCheckbox.checked = true;
                              sticksPerDayInput.disabled = false;
                              forYearsInput.disabled = false;
                            }

                            smokingCheckbox.addEventListener("change", function() {
                              if (this.checked) {
                                sticksPerDayInput.disabled = false;
                                forYearsInput.disabled = false;
                              } else {
                                sticksPerDayInput.disabled = true;
                                forYearsInput.disabled = true;
                                forYearsInput.value = '';
                                sticksPerDayInput.value = '';
                              }
                            });

                            const drinkingCheckbox = document.getElementById("drinking");
                            const shotPerdayInput = document.querySelector('input[name="shotPerday"]');
                            const beerPerdayInput = document.querySelector('input[name="beerPerday"]');


                            if (personal_his.includes(drinkingCheckbox.value)) {
                              drinkingCheckbox.checked = true;
                              shotPerdayInput.disabled = false;
                              beerPerdayInput.disabled = false;
                            }

                            drinkingCheckbox.addEventListener("change", function() {
                              if (this.checked) {
                                shotPerdayInput.disabled = false;
                                beerPerdayInput.disabled = false;
                              } else {
                                shotPerdayInput.disabled = true;
                                beerPerdayInput.disabled = true;
                                shotPerdayInput.value = '';
                                beerPerdayInput.value = '';
                              }
                            });
                            

                          //hospitatlization
                            const hospitalization = "{{$response->hospitalization}}";
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
                          const medicine_mnt = "{{$response->medicine_mnt}}";
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
                          const allergies = "{{$response->allergies}}";
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
                            var family_his = "{{$response->family_his}}";
                            var past_illness = "{{$response->past_illness}}";
                            var present_illness = "{{$response->present_illness}}";
                            var personal_his = "{{$response->personal_his}}";
                            var immunization_his = "{{$response->immunization_his}}";
                            var hospitalization = "{{$response->hospitalization}}";
                            var medicine_mnt = "{{$response->medicine_mnt}}";
                            var allergies = "{{$response->allergies}}";

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
                        </script>
                        @endif
                         @else
                         <div class="card-panel red lighten-3">
                           
                         </div>
                       @endif
                    </div>
                  </div>
              </div>
          </div>
        </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card">
            <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
                @if ($response->gender === 'Female')
                <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
                @elseif ($response->gender === 'Male')
                <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
                @endif
            </div> 
            <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
              <label style="font-size: 18px;" id="id">{{$response->id}}</label>
            </div>
          </div>  
          <div class="card">
            <div class="card-body" style="background-color:rgb(110, 155, 222);">
              <div class="row" >
                <div class="col-12"  style="color:#f5f2f2;font-weight:bold;font-size:12px">
                  <h5 style="color:#f5f2f2;font-weight:bold">Personal Data</h5>
                  <div class="form-group">
                    First Name: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->first_name}}</label><br>
                    Middle Name: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->middle_name}}</label><br>
                    Last Name: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->last_name}}</label><br>
                    Age: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->age}}</label><br>
                    Gender: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->gender}}</label><br>
                    <hr>
                    DOB: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{ date('m-d-Y', strtotime($response->BirthDate))}}</label><br>
                    Civil Status: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->civil_status}}</label><br>
                    Nationality: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->nationality}}</label><br>
                    Religion: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->religion}}</label><br>
                  </div>
                  <hr>
                    Contact Number: <br><label class="" id="firstname" style="text-transform: capitalize;font-size:16px;color:lightyellow;font-style:italic;">{{$response->ContactNo}}</label><br>
                </div>
                <div class="col-12">
                  <div class="form-group">

                  </div>
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

  {{-- <script src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"></script> --}}

<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
//Search-Input
  //  $(document).ready(function(){
  //     $("#submitBtn").click(function (event) { 
  // if (event.which == 13) { 
  //        event.preventDefault();
  //        var search = $(this).val();
  //        $('.submitBtn').click();   
  //        if(search != ""){
  //        $.ajax({
  //           type:'post',
  //           url:'/add-patient',
  //           data:{search:search},

  //           success:function(data){
  //             $('#myTable').html(data);   
  //           } 
  //        })
  //      }
  //     else{
  //           $('#myTable').html("");   
  //         }
  //      } 
  //     });
  //   }); 
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

 document.getElementById("firstname").addEventListener("mouseenter", function() {
  Swal.fire({
    title: "<small>Firstname: <b>{{$response->first_name}}</b></small> <br>" +
           "<small>Middlename: <b>{{$response->middle_name}}</b></small> <br>" +
           "<small>Lastname:  <b>{{$response->last_name}}</b></small>",
    icon: "info",
    showConfirmButton: false,
    allowOutsideClick: true,
    allowEscapeKey: true,
    timerProgressBar: true,
    toast: true,
    position: "top-end"
  });
});

document.getElementById("firstname").addEventListener("mouseleave", function() {
  Swal.close();
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

  if (!$("input[name='past_illness[]']:checked").length) {
    swal.fire({
      title: "Error",
      text: "Please select at least one Past Illness.",
      icon: "error",
      button: "OK",
    }).then(() => {
      event.preventDefault();
    });
  } else if (!$("input[name='immunization_his[]']:checked").length) {
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
        }else if (response.Error == 1){
                Swal.fire({
                  icon: "error",
                  title: response.Message,
                })
              }
      }
    });
  }
}); 

</script>
@endsection