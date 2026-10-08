<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
    .prescribed-medicine-list {
        display: grid;
        gap: 10px;
    }
    .medicine-section-title {
        display: block;
        margin: 0 0 10px;
        color: #415c7d;
        font-weight: 700;
        text-transform: uppercase;
    }
    .prescribed-medicine-item {
        padding: 12px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #f8fafd;
    }
    .prescribed-medicine-item strong {
        display: block;
        color: #203c65;
    }
    .prescribed-medicine-details,
    .prescribed-medicine-instruction {
        margin-top: 4px;
        color: #65758d;
        font-size: 13px;
    }
    .prescribed-medicine-empty {
        padding: 14px;
        color: #738196;
        text-align: center;
        border: 1px dashed #cad6e6;
        border-radius: 8px;
    }
    .otc-medicine-editor {
        display: none;
        margin-bottom: 14px;
        padding: 14px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #f8fafd;
    }
    .otc-medicine-row {
        position: relative;
        display: grid;
        grid-template-columns: 120px minmax(0, 1fr) auto;
        gap: 10px;
        align-items: end;
        margin-bottom: 10px;
    }
    .otc-medicine-row:focus-within { z-index: 20; }
    .otc-medicine-name-field { position: relative; }
    .otc-medicine-results {
        display: none;
        position: absolute;
        z-index: 1070;
        top: 100%;
        right: 0;
        left: 0;
        max-height: 220px;
        overflow-y: auto;
        border: 1px solid #cad6e6;
        border-radius: 0 0 8px 8px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(27, 52, 86, .15);
    }
    .otc-medicine-result,
    .otc-medicine-result-empty {
        padding: 10px 12px;
        border-bottom: 1px solid #edf1f6;
    }
    .otc-medicine-result { cursor: pointer; }
    .otc-medicine-result:hover { background: #eef4ff; }
    .otc-medicine-result strong,
    .otc-medicine-result small { display: block; }
    .otc-medicine-result small { color: #738196; }
    @media (max-width: 576px) {
        .otc-medicine-row { grid-template-columns: 1fr; }
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
            <div class="form-outline" id="prescribedMedicineSection">
              <div id="otcMedicineEditor" class="otc-medicine-editor">
                <span class="medicine-section-title">Medicine Given at New Medical Record</span>
                <div id="otcMedicineRows"></div>
                <button type="button" id="addOtcMedicine" class="btn btn-outline-primary btn-sm">
                  <i class="fa fa-plus"></i> Add Medicine
                </button>
              </div>
              <span class="medicine-section-title">Doctor-Prescribed Medicine</span>
              <div id="prescribed-medicine-list" class="prescribed-medicine-list">
                <div class="prescribed-medicine-empty">No doctor-prescribed medicine for this consultation.</div>
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

<template id="otcMedicineRowTemplate">
  <div class="otc-medicine-row">
    <div>
      <label class="form-label">Quantity</label>
      <input type="number" min="1" name="OTCmedpcs[]" class="form-control otc-medicine-quantity" placeholder="Pcs.">
    </div>
    <div class="otc-medicine-name-field">
      <label class="form-label">Medicine</label>
      <input type="text" name="OTCmedDescript[]" class="form-control otc-medicine-name" placeholder="Medicine name" autocomplete="off">
      <input type="hidden" name="idOTCMed[]" class="otc-medicine-stock-id">
      <div class="otc-medicine-results"></div>
    </div>
    <button type="button" class="btn btn-outline-danger remove-otc-medicine" aria-label="Remove medicine">
      <i class="fa fa-trash"></i>
    </button>
  </div>
</template>
