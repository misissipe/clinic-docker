<style>
.modal-header
 {
     background-color: rgb(110, 155, 222);
 }
 input {
  outline: 0;
  border-width: 0;
  color:rgb(58, 57, 57);
  }

 </style>
<div id="viewPatientRec2" class="modal fade viewPatientRec" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
          <h5 style="font-weight: bold; color:white;" class='col-12 modal-title text-center'>MEDICAL AND SOCIAL HEALTH HISTORY </h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="col-sm-12">
            {{-- @csrf --}}
            <input type="text" class=" col-sm-8 border-0 id" name="patientId"  id="id" style="font-weight:400;color:rgb(58, 57, 57)" hidden>
            <div class="form-group">
              <div>
                <div class="col-sm-12">
                  <div class="row" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)" >            
                      Name:
                      <input type="text" class=" col-sm-8 border-0 fullname" name=""  id="fullname" style="font-weight:400;color:rgb(58, 57, 57)" readonly>
                  </div>
              </div><hr>
            </div>
            Family Health History</span>:
            <div class="row" >
              <div class="col-sm-2">
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
                  <input type="checkbox" id="eye" name="family_his[]" value="Eye Disorder">
                  <label for="vehiceyele1">Eye Disorder</label><br>
                  <input type="checkbox" id="skin" name="family_his[]" value="Skin Problem">
                  <label for="skin">Skin Problem</label><br>
                  <input type="checkbox" id="kidney" name="family_his[]" value="Kidney Problem">
                  <label for="kidney">Kidney Problem</label><br>
                  <input type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                  <label for="gastrointestinal">Gastrointestinal disease</label><br>
                  <input type="checkbox" id="others" name="family_his[]" value="Others">
                  <label for="vehicle2">Others:</label><br>
                  <input class="form-control othersFamhis" type="text" id="othersFamhis" name="othersFamhis" value="" >
                </div>
              </div>
              <div class="col-sm-3" style="border-left: 1px solid rgb(207, 206, 206)" >
                <div class="form-group">
                  <div>
                    Personal Social History:
                  </div>
                  <input type="checkbox" id="smoking" name="personal_his[]" value="Smoking">
                  <label for="smoking">Smoking</label><br>
                  <div class="form-group w-50">
                    <label for="day">sticks/day</label><br>
                    <input class="form-control" type="number" id="" name="sticksPerDay" value="">
                    <label for="year">for year/s</label><br>
                    <input class="form-control" type="number" id="" name="forYears" value="" >
                  </div>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <br>
                  <input type="checkbox" id="drinking" name="personal_his[]" value="Drinking">
                  <label for="drinking">Drinking</label><br>        
                  <div class="form-group w-50">
                    <label for="shots">shot per day</label><br>
                    <input class="form-control" type="number" id="shots" name="shotPerday" value="">
                    <label for="beer">beer per day</label><br>
                    <input class="form-control" type="number" id="beer" name="beerPerday" value="">
                  </div>
                </div>
              </div>
            </div>
            <hr>
            {{-- Personal Health History --}}
            <div>
              <h6> Personal Health History: </h6>
            </div>
            {{-- Past Illness --}}
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  <div>Past Illness<span class="text-danger">*</span></div>
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
                <div class="form-group">
                  <br>
                  <input type="checkbox" id="Asthmas" name="past_illness[]" value="Asthmas">
                  <label for="Asthmas">Asthma</label><br>
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
                  <input type="checkbox" id="Hepatitis" name="past_illness[]" value="Hepatitis">
                  <label for="Hepatitis">Hepatitis</label><br>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <br>
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
                  <div>Present Illness</div>
                  <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                  <label for="ChestPain">Chest Pain</label><br>
                  <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                  <label for="Insomnia">Insomnia</label><br>
                  <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                  <label for="JointPains">Joint Pains</label><br>
                  <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                  <label for="Dizziness">Dizziness</label><br>    
                  <input type="checkbox" id="others" name="present_illness[]" value="Others">        
                  <label for="vehicle2">Others:</label><br>
                  <input class="form-control othersPres" type="text" id="othersPreIll" name="othersPreIll" value="" >
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
            </div>
            <hr>
            <label for="hospitalization">Do you have a history of hospitalization for serious illness, operation, fracture, or injury?</label><br>
            <input type="checkbox" class="hospital" id="hospital" value="If yes, please give details" name="hospitalization">&nbsp;If yes, please give details
            <input type="text" class="form-control" id="hospitalization_detail" name="hos_detail" value="" placeholder="" disabled><br>
            <label for="medicine">Are you taking any medicine regularly?</label><br>
            <input type="checkbox" class="medicines" id="medicine" value="If yes, name of drug/s"name="medicine_mnt">&nbsp;If yes, name of drug/s
            <input type="text" class="form-control" id="medicine_detail" name="med_detail" value="" placeholder="" disabled><br>
            <label for="allergies">Are you allergic to any food or medicine?</label><br>
            <input type="checkbox" class="allergiese" id="allergies" value="If yes, specify" name="allergies">&nbsp;If yes, specify
            <input type="text" class="form-control" id="allergies_detail" name="al_detail" value="" placeholder="" disabled><br>
            {{-- Immunization History --}}
            <div>Immunization History:<span class="text-danger">*</span></div>
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  <input type="checkbox" id="BGC" name="immunization_his[]" value="BGC">
                  <label for="BGC">BGC</label><br>
                  <input type="checkbox" id="Chic" name="immunization_his[]" value="ChickenPox">
                  <label for="Chic">Chicken Pox</label><br>
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
                  <input type="checkbox" id="others" name="immunization_his[]" value="Others">        
                  <label for="vehicle2">Others:</label><br>
                  <input class="form-control othersImmu" type="text" id="othersImmu" name="othersImmu" value="" >
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="Mumps">
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
                  <input type="checkbox" id="HepatitiA" name="immunization_his[]" value="Hepatitis A">
                  <label for="HepatitiA">Hepatitis A</label><br>
                  <input type="checkbox" id="HepatitisB" name="immunization_his[]" value="Hepatitis B">
                  <label for="HepatitisB">Hepatitis B</label><br>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-custom float-right" id="saveBtn">Save</button>
              <button type="button" id="button" class="btn btn-secondary btn-custom float-right" data-dismiss="modal">Cancel</button>
            </div>     
        </div>
      </div>
    </div>
  </div>
</div>



        