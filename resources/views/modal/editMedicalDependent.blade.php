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
    <div id="editDependentModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold;color:white;height:10px">EDIT DEPENDENT</h5>
                </div>
                <div class="modal-body">             
                <form action="/updateMedicalDependent" method="POST" id="updateMedicalDependent"> 
                    @csrf
                    <div id="dataStudent">
                        <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                        <input type="hidden" class="date" name="date" id="date" placeholder="date" value="">
                    
                        <label for="firstname">First Name<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="form-control firstname @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" required autocomplete="firstname" style="text-transform: capitalize;" placeholder="" />
                    
                        <label for="middlename">Middle Name</label>
                        <input type="text" name="middlename" id="middlename" class="form-control middlename" value="" style="text-transform: capitalize;" placeholder="(optional)" />
                    
                        <label for="lastname">Last Name<span class="text-danger">*</span></label>
                        <input type="text" name="lastname" id="lastname" class="form-control lastname @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" required autocomplete="lastname" style="text-transform: capitalize;" placeholder="" />
                    
                        <label for="bday">Birth Date:<span class="text-danger">*</span></label>
                        <input type="date" name="bday" id="bday" class="form-control bday @error('bday') is-invalid @enderror" value="{{ old('bday') }}" required autocomplete="bday" placeholder="" />
                    
                        <br>
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control mb-3 w-50 gender" id="gender">
                            <option value="" disabled selected>-Select-</option>
                            <?php
                            $gender = array("Male", "Female");
                            foreach ($gender as $genders) {
                                echo "<option value=\"$genders\">$genders</option>";
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
    </div> <!-- End Modal -->