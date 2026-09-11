<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="editSignatories" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'></h5>
            </div>
            <form action="/updateSignatories" method="POST" id="editSignatoriesModal">
                @csrf
                <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">First Name:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control FirstName" id="FirstName" name="FirstName" autocomplete="off" required>
                        <label for="recipient-name" class="col-form-label">Middle Initial:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control MiddleName" id="MiddleName" name="MiddleName" autocomplete="off" required>
                        <label for="recipient-name" class="col-form-label">Last Name & Extension:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control LastName" id="LastName" name="LastName" autocomplete="off" required>
                        <label for="title">Role</label><span class="text-warning">*</span>
                        <select name="role" class="form-control w-50 role" id="sy-select" required>
                            <option value="" disabled="disabled">-Select-</option>
                            <?php
                            $roles = array("Nurse", "Dentist", "Attendant", "Nurse Attendant");
                            foreach ($roles as $role) {
                                echo "<option value=\"$role\">$role</option>"; 
                            }
                            ?>
                        </select>
                        <label for="title">Designation</label>
                        <select name="designation" class="form-control w-50 designation" id="sy-select">
                            <option value="" disabled="disabled">-Select-</option>
                            <?php
                            $des = array("","Dental Assistant", "Director");
                            foreach ($des as $desi) {
                                echo "<option value=\"$desi\">$desi</option>";
                            }
                            ?>
                        </select>
                        <label for="recipient-name" class="col-form-label">Office:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control office" id="office" name="office" autocomplete="off">
                        <label for="title">Services</label>
                        <select name="services" class="form-control w-50 services" id="sy-select">
                            <option value="" disabled="disabled">-Select-</option>
                            <?php
                            $serv = array("","Medical", "Dental");
                            foreach ($serv as $ser) {
                                echo "<option value=\"$ser\">$ser</option>";
                            }
                            ?>
                        </select>
                        <label for="title">Employment Status</label>
                        <select name="emp" class="form-control w-50 services emp"  id="sy-select">
                            <option value="" disabled="disabled">-Select-</option>
                            <?php
                            $serv = array("Job Order","Permanent-Staff");
                            foreach ($serv as $ser) {
                                echo "<option value=\"$ser\">$ser</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
