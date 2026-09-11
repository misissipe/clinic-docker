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
<div class="modal fade" id="editStudentEmergency" tabindex="-1" role="dialog" aria-labelledby="editStudentEmergencyLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 style="font-weight: bold;color:white;" class='col-12 modal-title'>EDIT</h5>
        </div>
            <div id="nonPrintable" class="modal-body">
                <div class="form-group">
                    <form action="/updateEmergency" method="POST" id="updateEmergency"> 
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
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label for="address">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control EC_name @error('EC_name') is-invalid @enderror" name="EC_name" value="{{ old('EC_name') }}" required autocomplete="EC_name" id="EC_name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address">Contact No</label>
                        <input type="text" class="form-control EC_contactNo @error('EC_contactNo') is-invalid @enderror" name="EC_contactNo" value="{{ old('EC_contactNo') }}" required autocomplete="EC_contactNo" id="EC_contactNo">
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Address<span class="text-danger">*</span></label>
                          <input type="text" class="form-control EC_brgy @error('EC_brgy') is-invalid @enderror" name="EC_brgy" value="{{ old('EC_brgy') }}" required autocomplete="EC_brgy" id="EC_brgy" placeholder="Brgy">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control EC_city @error('EC_city') is-invalid @enderror" name="EC_city" value="{{ old('EC_city') }}" required autocomplete="EC_city" id="EC_city" placeholder="City">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control EC_province @error('EC_province') is-invalid @enderror" name="EC_province" value="{{ old('EC_province') }}" required autocomplete="province" id="EC_province" placeholder="Province">
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
