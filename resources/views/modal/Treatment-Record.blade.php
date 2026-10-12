<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="editTreatmentRecord" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold;color:white;" class='col-12 modal-title move'>TREATMENT RECORD</h5>
            </div>
            <div class="modal-body">    
                <form id="updateTreatmentRecordForm" action="{{ route('updateRecord') }}" method="POST">
                 @csrf
                    <input type="hidden" class="id" name="id" id="id" placeholder="id" >
                    <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 20px;">
                            <label for="example-month-input" class="col-2 ">date</label>
                            <input class="form-control col-sm-3 date float-right @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" value="" id="viewDate">
                        </div>
                    </div>
                    <div class="form-outline move">
                        <label  class="form-label" for="textAreaExample">Diagnosis:<span class="text-danger">*</span></label>
                        <textarea class="form-control diagnosis " name="diagnosis" value="" name="diagnosis" id="diagnosis" rows="5"></textarea>
                    </div>
                    <div class="form-outline move">
                        <label class="form-label" for="textAreaExample">Treatment:<span class="text-danger">*</span></label>
                        <textarea class="form-control treatment " name="treatment" value=""  id="treatment" rows="5"></textarea>
                    </div>
                    <div class="remarks">
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
                            <input type="checkbox" id="" name="remarks[]" value="Dental Certificate">
                            <label for="cancer" style="text-transform: capitalize;font-size:12px;">Dental Certificate</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="editOtcCheckbox" name="remarks[]" value="OTC Medicine">
                            <label for="editOtcCheckbox" style="text-transform:capitalize;font-size:12px;">OTC Medicine</label>
                        </div>
                        <div id="editOtcPanel" class="mt-1 p-1" style="display:none;border:1px solid #d7e0ed;border-radius:8px;background:#f8faff;">
                            <strong style="font-size:13px;color:#405a7b;">MEDICINE GIVEN AT DENTAL TREATMENT RECORD</strong>
                            <div class="row mt-1" style="font-size:11px;font-weight:bold;color:#405a7b;"><div class="col-2">QUANTITY</div><div class="col-9">MEDICINE</div></div>
                            <div id="editOtcRows"></div>
                            <button type="button" id="addEditOtc" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Add Medicine</button>
                        </div>
                        <div id="existingOtcPanel" class="mt-2" style="display:none;">
                            <strong style="font-size:13px;color:#405a7b;">MEDICINE ALREADY GIVEN AT TREATMENT RECORD</strong>
                            <div id="existingOtcCards"></div>
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
