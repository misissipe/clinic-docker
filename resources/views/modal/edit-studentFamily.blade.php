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
</style>
<style>
 textarea  {
    outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
  }
</style>
  <style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div class="modal fade" id="editStudentFamily" tabindex="-1" role="dialog" aria-labelledby="editStudentFamilyLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 style="font-weight: bold;color:white;" class='col-12 modal-title'>EDIT</h5>
        </div>
            <div id="nonPrintable" class="modal-body">
                <div class="form-group">
                    <form action="/updateFamily" method="POST" id="updateFamily"> 
                        @csrf
                  <input type="hidden" class="id" name="id" id="id"  value="" placeholder="" >
                 
                    {{-- <div class="col-sm-12">
                     <div class="row">            
                           Name:
                           <input type="text" class=" col-sm-8 border-0 fullname" name="fullname"  id="fullname"  readonly>
                      </div>
                   </div> --}}
                 </div><hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address">Father's Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control FatherName @error('FatherName') is-invalid @enderror" name="FatherName" value="{{ old('FatherName') }}" required autocomplete="FatherName" id="FatherName">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address">Father's Occupation</label>
                        <input type="text" class="form-control f_occupation @error('f_occupation') is-invalid @enderror" name="f_occupation" value="{{ old('f_occupation') }}" required autocomplete="f_occupation" id="f_occupation">
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Father's Address</label>
                          <input type="text" class="form-control f_officeadd @error('f_officeadd') is-invalid @enderror" name="f_officeadd" value="{{ old('f_officeadd') }}" required autocomplete="f_officeadd" id="f_officeadd">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Mother's Name<span class="text-danger">*</span></label>
                          <input type="text" class="form-control MotherName @error('MotherName') is-invalid @enderror" name="MotherName" value="{{ old('MotherName') }}" required autocomplete="MotherName" id="MotherName">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Mother's Occupation</label>
                          <input type="text" class="form-control m_occupation @error('m_occupation') is-invalid @enderror" name="m_occupation" value="{{ old('m_occupation') }}" required autocomplete="m_occupation" id="m_occupation">
                        </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                            <label for="address">Mother's Address</label>
                            <input type="text" class="form-control m_officeadd @error('m_officeadd') is-invalid @enderror" name="m_officeadd" value="{{ old('m_officeadd') }}" required autocomplete="m_officeadd" id="m_officeadd" >
                          </div>
                        </div>
                      </div>
                  <br>
                  <div class="modal-footer">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
