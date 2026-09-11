<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>

<div id="viewMedicalRecord" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 style="font-weight: bold; color:white;" class='col-12 modal-title'>EDIT RECORD</h5> --}}
            </div>
            <div class="modal-body">                  
            <form action="/update-record" method="POST" id="updateMedicalRecord"> 
                @csrf
                <input type="hidden" class="id" name="id" id="id" placeholder="id">
                 <input type="hidden" class="patientId" name="patientId" id="patientId" placeholder="patientId">
                <input type="hidden" class=" col-sm-2 firstname" name="firstname"  id="firstname" >
                <input type="hidden" class=" col-sm-2 middlename" name="middlename"  id="middlename"  >
                <input type="hidden" class=" col-sm-2 lastname" name="lastname"  id="lastname"  >
                    {{-- <div class="form-group"> 
                        <div class="col-sm-12">
                            <div class="row">            
                                Name:
                                <input type="text" class=" col-sm-6 fullname" name="fullname"  id="fullname" readonly>
                            </div>
                        </div>
                    </div><hr><br> --}}
               <div class="d-flex justify-content-end gap-4">
                <div>
                    <label for="viewDate" class="form-label">Date</label>
                    <input type="date" 
                        class="form-control @error('date') is-invalid @enderror" 
                        name="date" 
                        value="{{ old('date') }}" 
                        required 
                        id="viewDate">
                </div>
                <div>
                    <label for="viewTime" class="form-label">Time</label>
                    <input type="time" 
                        class="form-control @error('time') is-invalid @enderror" 
                        name="time" 
                        value="{{ old('time') }}" 
                        required 
                        id="viewTime"
                        step="1">
                </div>
            </div>
            <br>
                        <div style="font-weight: 400; font-size: 20px;">
                        <label for="purpose" style="display: inline-block;font-weight:700">Purpose of Visit:<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="form-check col-md-3" >
                                <input type="checkbox" id="Consultation" name="purpose[]" value="Consultation">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Consultation</label>
                            </div>
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="WD" name="purpose[]" value="Wound Dressing">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Wound Dressing</label>
                            </div>
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="BP" name="purpose[]" value="Blood Pressure">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Blood Pressure</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="PC" name="purpose[]" value="Provision of Comfort">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Provision of Comfort</label>
                            </div>
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="OM" name="purpose[]" value="OTC Medicine">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">OTC Medicine</label>
                            </div>
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="PA" name="purpose[]" value="Physical Assessment">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Physical Assessment</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="OC" name="purpose[]" value="Other Concerns">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Other Concerns</label>
                            </div>
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="IC" name="purpose[]" value="Issuance of Certificate">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Issuance of Certificate</label>
                            </div>
                            <div class="form-check col-md-3">
                                <input type="checkbox" id="Ref" name="purpose[]" value="Referral">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">Referral</label>
                            </div>
                        </div>
                    </div> 
                    <br>
                    <div class="form-outline ">
                        <label class="form-label" for="textAreaExample">Chief Complain/Findings:<span class="text-danger">*</span></label>
                        <textarea class="form-control  @error('findings') is-invalid @enderror" name="findings" value="{{ old('findings') }}" id="viewFindings" rows="5"></textarea>
                    </div>
                    <div class="form-outline" id="Parameter">
                        <label class="form-label" for="textAreaExample">Physiological Parameters:<span class="text-danger">*</span></label>
                        <textarea class="form-control  @error('parameters') is-invalid @enderror" name="parameters" value="{{ old('parameters') }}" id="viewParameters" rows="5"></textarea>
                    </div>
                    <div class="form-outline" id="Physiological">
                        <label class="form-label" for="textAreaExample">Physiological Parameters:</label>
                        <div class="form-inline">
                        <label class="form-label col-md-2" for="weight">Weight (KG):</label>
                        <input class="form-control col-md-1" type="number" id="weight" placeholder="" name="weight" step="0.1">
                    
                        <label class="form-label col-md-2" for="height">Height (CM):</label>
                        <input class="form-control col-md-1" type="number" id="height" placeholder="" name="height" step="0.1">
                    
                        <label class="form-label col-md-2" for="bloodType">Blood Type:</label>
                        <input class="form-control col-md-1" type="text" id="bloodType" placeholder="" name="bloodType" step="0.1">
                    
                        <label class="form-label col-md-2" for="temperature">Temperature:</label>
                        <input class="form-control col-md-1" type="number" id="temperature" placeholder="" name="temperature" step="0.1">
                    </div><br>
                    <div class="form-inline">
                        <label class="form-label col-md-2" for="pulse">Pulse:</label>
                        <input class="form-control col-md-1" type="number" id="pulse" placeholder="" name="pulse">
                        
                        <label class="form-label col-md-2" for="respiratoryRate">Respiratory Rate:</label>
                        <input class="form-control col-md-1" type="number" id="respiratoryRate" placeholder="" name="respiratoryRate">
                        
                        <label class="form-label col-md-2" for="bloodPressure">Blood Pressure:</label>
                        <input class="form-control col-md-2" type="text" id="bloodPressure" placeholder="" name="bloodPressure">
                    </div>
                </div>
                <div class="form-outline">
                    <label class="form-label" for="textAreaExample">Treatment/Recommendations:<span class="text-danger">*</span></label>
                        <textarea class="form-control " name="recommendation" value="{{ old('recommendation') }}"  id="viewRecommendation" rows="5"></textarea>
                </div>
                <br>
            <div class="form-outline" id="medicineOTC">
             <button class="btn btn-success" id="addNewinput" type="button">Add</button><br>
              <label class="form-label" style="display: inline-block;" for="textAreaExample">Medicine:<span class="text-danger">*</span></label>
              <div id="inputs-container">
                <div class="input-group">
                  <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." autocomplete="off">
                  <input type="text" class="form-control col-sm-6 OTCmedDescript" style="display: inline-block;" name="OTCmedDescript[]" aria-describedby="" placeholder="description" autocomplete="off">
                  <input type="hidden" class="form-control col-sm-6 idOTCMed" style="display: inline-block;" name="idOTCMed[]" autocomplete="off">
                  <input type="hidden" class="form-control col-sm-6 lotOTCMed" style="display: inline-block;" name="lotOTCMed[]" autocomplete="off">
                  <span class="text-danger stockWarning" style="display: none;"> Low stock! </span>
                  <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>&emsp;
                  <span class="text-danger expirationWarning" style="display:none;"></span>
                  {{-- <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button> --}}
                  <br><br>
                </div>
              </div>  
               
            </div>
            </div>
          
            <div class="modal-footer">
                <button id="submitBtn" type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div> 
        </div> 
    </div> 
</div>