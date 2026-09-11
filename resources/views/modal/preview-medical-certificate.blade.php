<!-- Modal -->
@php
use App\Http\Controllers\AESCipher;
@endphp  
<style> 
    table, th,td{
   border: 1px solid rgb(58, 57, 57);
   border-collapse: collapse;
   padding: 1px;
   text-align: center;
 }
 input {
  outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
 }

 textarea  {
    outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
  }
  .modal-header
  {
     background-color: rgb(110, 155, 222);
   }
</style>
<div id="">
<div class="modal fade bd-example-modal-lg preview"  id="preview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 style="font-weight: bold;color:white;" class='col-12 modal-title'>VIEW RECORD</h5>
        </div>
            <div id="nonPrintable" class="modal-body">
                <div class="form-group">
                  <form action="/update" method="POST" id="updateRecord"> 
                  @csrf
                  <input type="hidden" class="id" name="id" id="cert_id"  value="" placeholder="" >
                  <input type="hidden" class="id" name="patientId" id="id" placeholder="id" >
                  <input  class="form-control " name="role" type="" value="{{$role}}" id="" hidden> 
                  <input type="hidden" class=" col-sm-3 border-0 firstname" name="firstname"  id="firstname"  >
                  <input type="hidden" class=" col-sm-3 border-0 middlename" name="middlename"  id="middlename"  >
                  <input type="hidden" class=" col-sm-3 border-0 lastname" name="lastname"  id="lastname" >
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address">Weight<span class="text-danger">*</span></label>
                        <input type="text" class="form-control weight @error('weight') is-invalid @enderror" name="weight" value="{{ old('weight') }}" required autocomplete="weight" id="weight">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address">Height<span class="text-danger">*</span></label>
                        <input type="text" class="form-control height @error('height') is-invalid @enderror" name="height" value="{{ old('height') }}" autocomplete="height" id="height">
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Blood Type<span class="text-danger">*</span></label>
                          <input type="text" class="form-control bloodtype @error('bloodtype') is-invalid @enderror" name="bloodtype" value="{{ old('bloodtype') }}" autocomplete="bloodtype" id="bloodtype">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Temperature<span class="text-danger">*</span></label>
                          <input type="text" class="form-control temperature @error('temperature') is-invalid @enderror" name="temperature" value="{{ old('temperature') }}"  autocomplete="temperature" id="temperature">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Pulse Rate<span class="text-danger">*</span></label>
                          <input type="text" class="form-control pulse_rate @error('pulse_rate') is-invalid @enderror" name="pulse_rate" value="{{ old('pulse_rate') }}"  autocomplete="pulse_rate" id="pulse_rate">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Respiratory Rate<span class="text-danger">*</span></label>
                          <input type="text" class="form-control res_rate @error('res_rate') is-invalid @enderror" name="res_rate" value="{{ old('res_rate') }}"  autocomplete="res_rate" id="res_rate">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Blood Pressure<span class="text-danger">*</span></label>
                          <input type="text" class="form-control bp @error('bp') is-invalid @enderror" name="bp" value="{{ old('bp') }}"  autocomplete="bp" id="bp">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Allergies<span class="text-danger">*</span></label>
                          <input type="text" class="form-control allergies " name="allergies" value="{{ old('allergies') }}"  id="allergies">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Medication<span class="text-danger">*</span></label>
                          <input type="text" class="form-control medication " name="medication" value="{{ old('medication') }}" id="medication">
                        </div>
                      </div>
                    </div>
                  <div class="form-outline">
                    <label class="form-label" for="textAreaExample">Diagnosis:<span class="text-danger">*</span></label>
                    <textarea class="form-control diagnosis @error('diagnosis') is-invalid @enderror" name="diagnosis" value="{{ old('diagnosis') }}"  autocomplete="diagnosis" id="diagnosis" rows="2"></textarea>
                  </div>
                  <div class="form-outline">
                    <label class="form-label" for="textAreaExample">Remarks:</label>
                    <textarea class="form-control remarks @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" autocomplete="remarks" id="remarks" rows="2"></textarea>
                  </div>
                  <br>
                  <div class="form-group">
                    <div>
                      THIS CERTIFICATION IS ISSUED upon request of the above-name student/employee as requirement for:<span class="text-danger">*</span>
                    </div>
                    <input type="checkbox" id="OJT" name="cert_issued[]" value="OJT" onclick="selectBox('OJT')">
                    <label for="ChestPain">On-the-Job Training</label><br>
                    <input type="checkbox" id="work" name="cert_issued[]" value="Return for Work" onclick="selectBox('work')">
                    <label for="Insomnia">Return for Work</label><br>
                    <input type="checkbox" id="Travel" name="cert_issued[]" value="Travel" onclick="selectBox('Travel')">
                    <label for="JointPains">Travel</label><br>
                    <input type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity" onclick="selectBox('Off-campus Activity')">
                    <label for="Dizziness">Off-campus activity</label><br>
                    <input type="checkbox" id="others" name="cert_issued[]" value="Others" onclick="selectBox('others')">            
                    <label for="vehicle2">Others,please specify</label><br>
                    <input class="form-control othersPreIll col-sm-10 othersinput" type="text" id="othersinput" name="others" value="" >
                  </div>
                  <div class="modal-footer">
                    <button id="submitBtn" type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
