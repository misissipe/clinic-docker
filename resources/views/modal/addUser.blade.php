<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
     select option:hover {
        cursor: pointer;
    }
</style>
<!-- Editing form modal -->
    <div id="addUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold;color:white;height:10px">ADD USER</h5>
                </div>
                <div class="modal-body">             
                <form action="/addUser" method="POST" id="addModal"> 
                    @csrf
                        <div id="dataStudent" >
                            {{-- <label for="fname">ID</label>
                            <input type="number" name="id"  id="firstname" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="ag" placeholder="---" /> --}}

                            <label for="fname">Employee ID<span class="text-danger">*</span></label>
                            <input type="number" id="firstname" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" required autocomplete="off" placeholder="Input ID" />

                            <label for="fname">First Name<span class="text-danger">*</span></label>
                            <input type="firstname" name="firstname"  id="firstname" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="off" placeholder="" />
                            
                            <label for="mname">Middle Name<span class="text-danger">*</span></label>
                            <input type="middlename" name="middlename"  id="middlename" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" required autocomplete="off" placeholder="" />
                           
                            <label for="lname">Last Name<span class="text-danger">*</span></label>
                            <input type="lastname" name="lastname"  id="lastname" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="off" placeholder="" />
     
                            <label for="email">Email Address<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off"  placeholder="" />
                            
                            <br>
                            <label for="title">Role</label>
                            <select name="role" class="form-control  mb-3 w-50" id="sy-select">
                                <option value="disable selected">-Select-</option>
                                <?php
                                $roles = array("Admin","Attendant", "Dentist", "Doctor", "Nurse", "Nurse Attendant");
                                foreach ($roles as $role) {
                                    echo "<option value=\"$role\">$role</option>";
                                }
                                ?>
                           </select>
                        </div>
                        <div class="modal-footer">
                            <button id="submitBtn" type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                </form>
                </div> 
            </div> 
        </div> 
    </div> <!-- End Modal -->