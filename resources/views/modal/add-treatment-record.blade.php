<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<div id="addTreatmentRecord" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold;color:white;" class='col-12 modal-title move'>TREATMENT RECORD</h5>
            </div>
            <div class="modal-body">       
                <form id="addTreatmentForm" action="{{ route('addRecord') }}" method="POST">       
                {{-- <form action="/add-treatment-record" method="POST" id="addTreatmentRecord">  --}}
                @csrf
                    {{-- <input type="text" class="patientId" name="patientId" id="patientId" placeholder="patientId" > --}}
                    <input type="hidden" class="patientId" name="id" id="patientId" placeholder="patientId" >
                    <input type="hidden" class="role" name="role" id="role" placeholder="role" >
                    <input type="hidden" class="gender" name="gender" id="gender" placeholder="gender" >
                    <input type="hidden" class="age" name="age" id="age" placeholder="age" >
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
                                <input type="checkbox" id="" name="remarks[]" value="OTC Medicine">
                                <label for="cancer" style="text-transform: capitalize;font-size:12px;">OTC Medicine</label>
                              </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button id="submitBtn" type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div> 
        </div> 
</div> <!-- End Modal -->