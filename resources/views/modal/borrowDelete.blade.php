<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="deletedBorrowModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>Add Doctor</h5>
            </div>
            <form action="/addDoctors" method="POST" id="addDoctorsModal">
                @csrf
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" >License:</label><span class="text-warning">*</span>
                        <input type="number" class="form-control" id="license" name="license" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">First Name:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control" id="FirstName" name="FirstName" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Middle Initial:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control" id="MiddleName" name="MiddleName" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Last Name & Extension:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control" id="LastName" name="LastName" autocomplete="off">
                        <label for="title">Specialization</label>
                        <select name="specialization" class="form-control  mb-3 w-50" id="sy-select">
                            <option value="disable selected">-Select-</option>
                            <?php                                                                        
                            $roles = array("Physician", "Dentist");  
                            foreach ($roles as $role) {
                                echo "<option value=\"$role\">$role</option>";
                            }
                            ?>
                       </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
