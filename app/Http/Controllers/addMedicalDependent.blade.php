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
    <div id="addMedicalDependentModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold;color:white;height:10px">ADD MEDICAL DEPENDENT</h5>
                </div>
                <div class="modal-body">              
                <form action="/addnewMedicalDependent" method="POST" id="addModal"> 
                    @csrf
                        <div id="dataStudent" >
                            {{-- <label for="fname">ID</label>
                            <input type="number" name="id"  id="firstname" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="ag" placeholder="---" /> --}}
                            <input type="hidden" class="id" name="employeeId" id="id" placeholder="id" value="">
                            <input type="hidden" class="date" name="date" id="date" placeholder="date" value="">

                            <label for="fname">First Name<span class="text-danger">*</span></label>
                            <input type="firstname" name="firstname"  id="firstname" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required aautocomplete="off" style="text-transform: capitalize;" placeholder="" />
                            
                            <label for="mname">Middle Name</label>
                            <input type="middlename" name="middlename"  id="middlename" class="form-control " name="middlename" value="" style="text-transform: capitalize;" autocomplete="off" placeholder="(optional)" />
                           
                            <label for="lname">Last Name<span class="text-danger">*</span></label>
                            <input type="lastname" name="lastname"  id="lastname" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="off" style="text-transform: capitalize;" placeholder="" />
     
                            <label for="bday">Birth Date:<span class="text-danger">*</span></label>
                            <input type="date" name="bday" id="bday" class="form-control @error('bday') is-invalid @enderror" name="bday" value="{{ old('bday') }}" required autocomplete="bday"  placeholder="" />
                            
                            <br>
                            <label for="title">Gender</label>
                            <select name="gender" class="form-control  mb-3 w-50" id="sy-select">
                                <option value="disable selected">-Select-</option>
                                <?php
                                $gender = array("Male", "Female");
                                foreach ($gender as $genders) {
                                    echo "<option value=\"$genders\">$genders</option>";
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