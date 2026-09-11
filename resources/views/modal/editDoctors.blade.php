<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="editDoctors" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>Edit Product</h5>
            </div>
            <form action="/updateDoctors" method="POST" id="editDoctorsModal">
                @csrf
                <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" >License:</label><span class="text-warning">*</span>
                        <input type="number" class="form-control license" id="license" name="license" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">First Name:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control FirstName" id="FirstName" name="FirstName" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Middle Initial:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control MiddleName" id="MiddleName" name="MiddleName" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Last Name & Extension:</label><span class="text-warning">*</span>
                        <input type="text" class="form-control LastName" id="LastName" name="LastName" autocomplete="off">
                        <label for="title">Specialization</label>
                        <select name="specialization" class="form-control  mb-3 w-50 specialization" id="specialization">
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
                    <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
