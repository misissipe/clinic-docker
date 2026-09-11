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
<div class="modal fade" id="editEmployeeinfo" tabindex="-1" role="dialog" aria-labelledby="editEmployeeinfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 style="font-weight: bold;color:white;" class='col-12 modal-title'>EDIT</h5>
        </div>
            <div id="nonPrintable" class="modal-body">
                <div class="form-group">
                    <form action="/updatePersonalEmp" method="POST" id="updatePersonalEmp"> 
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
                        <label for="address">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control FirstName @error('FirstName') is-invalid @enderror" name="FirstName" value="{{ old('FirstName') }}" required autocomplete="FirstName" id="FirstName" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address"></label>
                        <input type="text" class="form-control MiddleName @error('MiddleName') is-invalid @enderror" name="MiddleName" value="{{ old('MiddleName') }}" required autocomplete="MiddleName" id="MiddleName" placeholder="Middle Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control LastName @error('LastName') is-invalid @enderror" name="LastName" value="{{ old('LastName') }}" required autocomplete="LastName" id="LastName" placeholder="Last Name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Birth Date<span class="text-danger">*</span></label>
                          <input type="date" class="form-control DateOfBirth @error('DateOfBirth') is-invalid @enderror" name="DateOfBirth" value="{{ old('DateOfBirth') }}" required autocomplete="DateOfBirth" id="DateOfBirth">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Age<span class="text-danger">*</span></label>
                          <input type="text" class="form-control Age @error('Age') is-invalid @enderror" name="Age" value="{{ old('Age') }}" required autocomplete="Age" id="Age" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Contact No.<span class="text-danger">*</span></label>
                          <input type="text" class="form-control Cellphone @error('Cellphone') is-invalid @enderror" name="Cellphone" value="{{ old('Cellphone') }}" required autocomplete="Cellphone" id="Cellphone">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Civil Status<span class="text-danger">*</span></label>
                          <input type="text" class="form-control CivilStatus @error('CivilStatus') is-invalid @enderror" name="CivilStatus" value="{{ old('CivilStatus') }}" required autocomplete="CivilStatus" id="CivilStatus">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Nationality<span class="text-danger">*</span></label>
                          <input type="text" class="form-control Citizenship @error('Citizenship') is-invalid @enderror" name="Citizenship" value="{{ old('Citizenship') }}" required autocomplete="Citizenship" id="Citizenship">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Email Address<span class="text-danger">*</span></label>
                          <input type="text" class="form-control EmailAddress @error('EmailAddress') is-invalid @enderror" name="EmailAddress" value="{{ old('EmailAddress') }}" required autocomplete="EmailAddress" id="EmailAddress">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Address<span class="text-danger">*</span></label>
                          <input type="text" class="form-control RBarangay @error('RBarangay') is-invalid @enderror" name="RBarangay" value="{{ old('RBarangay') }}" required autocomplete="RBarangay" id="RBarangay" placeholder="RBarangay">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control citymunDesc @error('citymunDesc') is-invalid @enderror" name="citymunDesc" value="{{ old('citymunDesc') }}" required autocomplete="citymunDesc" id="citymunDesc" placeholder="citymunDesc">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control provDesc @error('provDesc') is-invalid @enderror" name="provDesc" value="{{ old('provDesc') }}" required autocomplete="provDesc" id="provDesc" placeholder="provDesc">
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
