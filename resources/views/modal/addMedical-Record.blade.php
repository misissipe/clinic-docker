<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
    <div id="editMedicalRecord" class="modal fade"> 
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold;color:white;" class='col-12 modal-title'>ADD NEW RECORD</h5>
                </div>
                <div class="modal-body">
                  <form action="/saveEditRefer" method="POST" id="saveModalAdd"> 
                   @csrf
                    <input type="text" class="id" name="patientId" id="id" placeholder="id" hidden>

                <div class="form-group">
                  <div class="col-sm-12">
                   <div class="row">            
                         Name:
                         <input type="text" class=" col-sm-2 lastname" name="lastname"  id="lastname"  readonly> 
                         <input type="text" class=" col-sm-2 firstname" name="firstname"  id="firstname"  readonly>
                         <input type="text" class=" col-sm-2 middlename" name="middlename"  id="middlename"  readonly>
                    </div>
                 </div>
               </div><hr><br>
               <div style="text-align: right">
                  <div style="font-weight: 400; font-size: 20px;">
                      <label for="example-month-input" class="col-1 ">date<span class="text-danger">*</span></label>
                      <input class="form-control col-sm-3 float-right @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" value="" id="date" name="date">
                  </div>
               </div>
               <div class="form-outline ">
                  <label class="form-label" for="textAreaExample">Chief Complain/Findings:<span class="text-danger">*</span></label>
                  <textarea class="form-control @error('findings') is-invalid @enderror" name="findings" value="{{ old('findings') }}" required autocomplete="off" id="findings" rows="5"></textarea>
               </div>
               <div class="form-outline">
                  <label class="form-label" for="textAreaExample">Physiological Parameters:<span class="text-danger">*</span></label>
                  <textarea class="form-control @error('parameters') is-invalid @enderror" name="parameters" value="{{ old('parameters') }}" required aautocomplete="off" id="parameters" rows="5"></textarea>
               </div>
               <div class="form-outline">
                  <label class="form-label" for="textAreaExample">Treatment/Recommendations:<span class="text-danger">*</span></label>
                  <textarea class="form-control @error('recommendation') is-invalid @enderror" name="recommendation" value="{{ old('recommendation') }}" required autocomplete="off"  id="recommendation" rows="5"></textarea>
               </div>
            </div>

            <div class="modal-footer">
                <button id="submitBtn" type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
             </form>
          </div> 
        </div> 
    </div> 
</div> <!-- End Modal -->