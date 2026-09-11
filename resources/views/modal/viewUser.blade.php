<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="viewUserModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color:white;" class='col-12 modal-title'>Edit USER</h5>
            </div>
            <div class="modal-body">               
                <form action="/updateUser" method="POST" id="updateModal"> 
                @csrf
                    <div id="dataStudent" >
                        <label for="fname">Employee ID<span class="text-danger">*</span></label>
                        <input type="number" name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" required autocomplete="employee_id" placeholder="---" />

                        <label for="fname">First Name<span class="text-danger">*</span></label>
                        <input type="firstname" name="firstname"  id="firstname" class="form-control firstname @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" placeholder="---" />
                        
                        <label for="mname">Middle Name<span class="text-danger">*</span></label>
                        <input type="middlename" name="middlename"  id="middlename" class="form-control middlename @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" required autocomplete="middlename" placeholder="---" />
                        
                        <label for="lname">Last Name<span class="text-danger">*</span></label>
                        <input type="lastname" name="lastname"  id="lastname" class="form-control lastname @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" placeholder="---" />

                        <label for="email">Email Address<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control email @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="---" />
                            
                        <br>
                        <label for="title">Role</label>
                        <select name="role" class="form-control mb-3 w-50" id="role-select" required>
                            <option value="disable selected">-Select-</option>
                            <?php
                            $roles = array("Admin","Attendant", "Dentist", "Doctor","Employee","Nurse", "Nurse Attendant");
                            foreach ($roles as $role) {
                                echo "<option value=\"$role\">$role</option>";
                            }
                            ?>
                        </select>
                            
                    </div>
                    <div class="modal-footer">
                        <button id="submitBtn" type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div> 
        </div> 
    </div> 
</div>